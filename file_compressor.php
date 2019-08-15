<?php

//set file locations for compressed and uncompressed files
$dir_original = '/Users/quinn.bennett/Downloads/';
$dir_compressed = '/Users/quinn.bennett/Pictures/CompressedFiles/';

//grab .png files from $original_dir and create array $png
$png_all = shell_exec('find ' . $dir_original.='*.png');
$png = explode("\n", $png_all);

//compress each file in $png and send compressed files to $dir_compressed
foreach ($png as $num => $file) {
  if ($num < (count($png)-1)) {
    $filename = basename($file);
    $compressed_file = $dir_compressed . 'compressed_' . $filename;
    shell_exec('pngquant --quality=60-90 --force - >' . $compressed_file . '<' . $file);
    echo "compressed: \033[1;30m" . $file . " \033[0m";

    $gap_a = (strlen($dir_original)+25)-strlen($file);
    for ($x=0;$x<$gap_a;$x++) {
      echo " ";
    }

    humanRead_FileSize($file);

    $gap_b = (10-strlen($size));
    for ($x=0;$x<$gap_b;$x++) {
      echo " ";
    }

    echo "to: \033[1;34m" . $compressed_file . " \033[0m";

    $gap_c = (strlen($dir_compressed)+40)-strlen($compressed_file);
    for ($x=0;$x<$gap_c;$x++) {
      echo " ";
    }

    humanRead_FileSize($compressed_file);
    echo "\n";
  }
}

function humanRead_FileSize($file) {
global $size;
$filesize = filesize($file);

  if ($filesize<1024) {
    $size = $filesize . "B";
  }
  elseif (1023<$filesize && $filesize<1048576) {
    $size = round($filesize/1024) . "KB";
  }
  else {
    $size = round($filesize/1048576) . "MB";
  }

  echo "\033[0;31m" . $size . " \033[0m";
}

?>
