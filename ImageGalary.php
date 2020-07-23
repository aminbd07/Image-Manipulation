<?php

/**
 * Image Galary Starter PHP
 * @author WpAdroit
 */
class ImageGalary
{
	public function __construct()
	{
		echo "Hello World !!";
	}
}

/**
 *
 * @return ImageCroper class 
 **/
function start()
{
	new ImageGalary();
}

start();