<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Imgresizer
 * Dynamic image creation library
 *
 * Imgresizer creates images of desired sizes based on a number of inputs.
 * It is based on the "Smart Image Resizer" by Joe Lencioni over at
 * http://shiftingpixel.com.
 *
 * Features:
 * + Resizes jpg, png & gifs based on width or height (if both set they'll act as max sizes)
 * + Sharpening jpgs (for crispier viewing at any size)
 * + Cropping based on ratios (like 16:9)
 * + Colorfill for transparent gif & pngs
 * + Caches the resized image
 * + Optional outputting of an <img>-tag. Therefore it can be used only for discreet resizing.
 *
 * Requirements:
 * PHP 5.1+
 * GD2
 *
 * Usage:
 *
 * In your controller:
 * $this->load->library('imgresizer');
 *
 * Syntax
 * $this->imageresizer->create(array settings, bool output);
 *
 * In your view:
 * $this->imgresizer->create(array('filename' => 'myimage.jpg', 'width' => 300));
 * This will output a version of myimage.jpg which is 300px wide and maintain the aspect ratio.
 *
 * The settings that can be included in the array is:
 * filename (required), folder, width, height, cropratio (should be something like 4:3),
 * sharpen (true or false), quality (0-100), color (#fff or #ffffff for white),
 * nocache (true or false), alt, title, rel, id
 *

 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Image Manipulation
 * @author		Johan André <johanandre@me.com>
 * @version		1.0
 * @license		http://creativecommons.org/licenses/by-sa/3.0/us/
 */

class Imgresizer
{
	public $memory_to_allocate		= '100M';

	public $offset_x					= 0;
	public $offset_y					= 0;

	public $dst							= '';
	public $src							= '';

	public $settings = array(
								'filename'	=> FALSE,
								'folder'	=> 'resources/clips/',
								'cache_dir'	=> 'resources/cache/',
								'quality'	=> 100,
								'width'		=> 9999999999,
								'height'	=> 9999999999,
								'cropratio'	=> FALSE,
								'sharpen'	=> TRUE,
								'color'		=> FALSE,
								'nocache'	=> FALSE,
								'alt'		=> 'Image',
								'class'		=> FALSE,
								'rel'		=> FALSE,
								'title'		=> FALSE,
								'id'		=> FALSE
							);

	public $defaults = array();

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function create($attr = array(), $output = TRUE)
	{
		$this->defaults = $this->settings;
		$this->settings['quality'] = 100;

		foreach ($attr as $key => $value)
		{
			$this->settings[$key] = $value;
		}
		$this->settings['output'] = $output;

		$attr = getimagesize('resources'.'/'.$this->settings['folder'].'/'.$this->settings['filename']);
		list($this->src_w, $this->src_h) = $attr;
		$this->src_mime = $attr['mime'];

		if (substr($this->src_mime, 0, 6) != 'image/')
		{
			//die('Error: Input file is not an image.');
			return '<img src="' . site_url('img/broken.png') . '" width="' . $this->settings['width'] . '" />';
		}

		$this->offset_x = 0;
		$this->offset_y = 0;

		if ($this->settings['cropratio'])
		{
			list($this->crop_ratio_x, $this->crop_ratio_y) = explode(':', $this->settings['cropratio']);
			$this->ratio_computed		= $this->src_w / $this->src_h;
			$this->crop_ratio_computed	= (float) $this->crop_ratio_x / (float) $this->crop_ratio_y;

			if ($this->ratio_computed < $this->crop_ratio_computed)
			{
				$origHeight	= $this->src_h;
				$this->src_h = $this->src_w / $this->crop_ratio_computed;
				$this->offset_y = ($origHeight - $this->src_h) / 2;
			}
			else if ($this->ratio_computed > $this->crop_ratio_computed)
			{
				$origWidth	= $this->src_w;
				$this->src_w = $this->src_h * $this->crop_ratio_computed;
				$this->offset_x	= ($origWidth - $this->src_w) / 2;
			}

		}

		$this->x_ratio	= $this->settings['width'] / $this->src_w;
		$this->y_ratio	= $this->settings['height'] / $this->src_h;

		if ($this->x_ratio * $this->src_h < $this->settings['height'])
		{
			// Resize the image based on width
			$this->dst_h = round($this->x_ratio * $this->src_h);
			$this->dst_w = $this->settings['width'];
		}
		else
		{
			// Resize the image based on height
			$this->dst_w = round($this->y_ratio * $this->src_w);
		 	$this->dst_h = $this->settings['height'];
		}

		$fmod =  filemtime ('resources'.'/'.$this->settings['folder'].'/'.$this->settings['filename']);

		$this->new_filename	= $this->settings['cache_dir'] . md5($fmod.'+'.$this->dst_w . '+' . $this->dst_h . '+' . implode('+', $this->settings)) . '-' . $this->settings['filename'];

		if (!$this->settings['nocache'] && file_exists($this->new_filename))
		{
			return $this->output();
		}
		else
		{
			ini_set('memory_limit', $this->memory_to_allocate);

			$this->dst = imagecreatetruecolor($this->dst_w, $this->dst_h);

			switch ($this->src_mime)
			{
				case 'image/gif':
					$this->src						= imagecreatefromgif('resources'.'/'.$this->settings['folder'].'/'.$this->settings['filename']);
					$this->src_mime				= 'image/png';
					$this->settings['sharpen'] = FALSE;
					$this->settings['quality'] = round(10 - ($this->settings['quality'] / 10));
				break;

				case 'image/x-png':
				case 'image/png':
					$this->src						= imagecreatefrompng('resources'.'/'.$this->settings['folder'].'/'.$this->settings['filename']);
					$this->settings['sharpen'] = FALSE;
					$this->settings['quality'] = round(10 - ($this->settings['quality'] / 10));
				break;

				default:
					$this->src						= imagecreatefromjpeg('resources'.'/'.$this->settings['folder'].'/'.$this->settings['filename']);
				break;
			}

			if (in_array($this->src_mime, array('image/gif', 'image/png')))
			{
				if (!$this->settings['color'])
				{
					imagealphablending($this->dst, false);
					imagesavealpha($this->dst, true);
				}
				else
				{
					$color = $this->settings['color'];
					if ($color[0] == '#')
						$color = substr($color, 1);

					$background	= FALSE;

					if (strlen($color) == 6)
						$background	= imagecolorallocate($this->dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
					else if (strlen($color) == 3)
						$background	= imagecolorallocate($this->dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
					if ($background)
						imagefill($this->dst, 0, 0, $background);
				}
			}

			imagecopyresampled($this->dst, $this->src, 0, 0, $this->offset_x, $this->offset_y, $this->dst_w, $this->dst_h, $this->src_w, $this->src_h);
			//imagecopyresampled($this->dst, $this->src, 0, 0, $this->offset_x, 0, $this->dst_w, $this->dst_h, $this->src_w, $this->src_h);

			if ($this->settings['sharpen'])
			{
				$sharpness	= $this->find_sharp($this->src_w, $this->dst_w);

				$sharpen_matrix	= array(
					array(-1, -2, -1),
					array(-2, $sharpness + 12, -2),
					array(-1, -2, -1)
				);
				$divisor	= $sharpness;
				$offset = 0;
				imageconvolution($this->dst, $sharpen_matrix, $divisor, $offset);
			}

			switch($this->src_mime)
			{
				case 'image/x-png':
				case 'image/png':
					imagepng($this->dst, $this->new_filename, $this->settings['quality']);
					break;
				default:
					imagejpeg($this->dst, $this->new_filename, $this->settings['quality']);
					break;
			}

			imagedestroy($this->src);
			imagedestroy($this->dst);

			return $this->output();
		}

		$this->settings = $this->defaults;
		unset($this->src_w, $this->src_h, $this->dst_w, $this->dst_h, $this->crop_ratio_computed, $this->ratio_computed, $this->offset_x, $this->offset_y);
	}

	public function output()
	{
		if ($this->settings['output'])
		{
			$this->CI->load->helper('html');

			$image_properties = array(
				'src' => $this->new_filename,
				'width' => $this->dst_w,
				'height' => $this->dst_h,
			);

			if($this->settings['alt']) $image_properties['alt'] = $this->settings['alt'];
			if($this->settings['class']) $image_properties['class'] = $this->settings['class'];
			if($this->settings['rel']) $image_properties['rel'] = $this->settings['rel'];
			if($this->settings['title']) $image_properties['title'] = $this->settings['title'];
			if($this->settings['id']) $image_properties['id'] = $this->settings['id'];

			return img($image_properties);
		}
	}

	function find_sharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
	{
		$final	= $final * (750.0 / $orig);
		$a		= 52;
		$b		= -0.27810650887573124;
		$c		= .00047337278106508946;

		$result = $a + $b * $final + $c * $final * $final;

		return max(round($result), 0);
	}
}