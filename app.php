<?php

function addLine($line, &$xmlArray) {
  $indent = str_replace('</dict>', '  ', $xmlArray[$line]);

  array_splice( $xmlArray, $line, 0, array($indent . '<key>IOPCITunnelCompatible</key>'));
  array_splice( $xmlArray, $line + 1, 0, array($indent . '<true/>'));
}


function parseFile($file, $output) {

  $xmlstring =  file_get_contents($file);

  // backup
  file_put_contents('backup'.time().'/'.$output, $xmlstring);

  $xmlArray = explode(PHP_EOL, $xmlstring);

  $line = 48;
  $diff = 0;
  $prevPos = 0;

  foreach ($xmlArray as $key => $value) {

    $pos = strpos($value, '<key>CFBundleIdentifier</key>');
    if($pos > 1) {
      $prevKey = $key;
      $prevPos = $pos-1; // identify the level
    }

    if($prevKey) {

      if (strpos($value, '</dict>') === $prevPos) {
        addLine($key + $diff, $xmlArray);
        $diff += 2;
        $prevKey = null;
      }
    }
  }

  file_put_contents($file, implode(PHP_EOL, $xmlArray));
}

if(!is_dir('output')) {
  mkdir('output');
}

if(!is_dir('backup'.time())) {
  mkdir('backup'.time());
}

parseFile('/System/Library/Extensions/NVDAStartup.kext/Contents/Info.plist', 'NVDAStartup.kext');
parseFile('/System/Library/Extensions/IONDRVSupport.kext/Info.plist', 'IONDRVSupport.kext');
parseFile('/System/Library/Extensions/AppleHDA.kext/Contents/PlugIns/AppleHDAController.kext/Contents/Info.plist', 'AppleHDA.kext');

?>
