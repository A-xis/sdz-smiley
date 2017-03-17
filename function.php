<?php
function getcache(){
	// On recupere le bon cache
if (isset($_GET['cache']))
{
    if(trim($_GET['cache']) == "full")
        $cache = "full";
    else
        if(trim($_GET['cache']) == "carre")
            $cache = "carre";
        else
            $cache = "simple";
    }
    else
        $cache = "simple";
    return $cache;
}

function generate_folder($dir, $type, $cache, $folder) {
	$dirIgnore = array ('.','..', 'name.txt', 'hidden.txt');
	$handle = opendir('./'.$dir.'/'.$folder);
	$smileys = array();
	if(file_exists('./'.$dir.'/'.$folder.'/hidden.txt') AND $type != "full") //si on masque des smileys
		{
			$hidden = explode("\n", file_get_contents('./'.$dir.'/'.$folder.'/hidden.txt'));
		}
		else
			$hidden = array();
	while ($file = readdir($handle))
	{
		if(!in_array($file, $dirIgnore) && !in_array($file, $hidden))
			$smileys[]='<a href="#" onclick="display(\''.$dir.'/'.$folder.'/'.$file.'\');"><img src="./'.$dir.'/'.$folder.'/'.$file.'" alt="'.$file.'" /></a>';
	}
	closedir($handle);
	return $smileys;
}

function generate_members($dir, $type, $cache)
{
	$dirIgnore = array ('.','..', 'name.txt', 'hidden.txt');
	$memberDir = array();
	$handle = opendir('./'.$dir.'/m');
	$i = 0;
	while ($file = readdir($handle)) 
	{
		if (!in_array($file,$dirIgnore)) 	
			$memberDir[] = $file;
	}
	closedir($handle);
	// tri alphabétique pour système Unix (bien chiant ça ...)
	usort($memberDir, "strcasecmp");
		//debut de la partie unique pour chaque dossier
	foreach($memberDir as $number => $value)
	{
		// gestion des changements de noms
		if(file_exists('./'.$dir.'/m/'. $value .'/name.txt'))
		{
			$fname = fopen('./'.$dir.'/m/'. $value .'/name.txt', 'r');
			$name = fgets($fname);
			fclose($fname);
		}
		else
			$name = $value;
		$memberSmiley = generate_folder($dir, $type, $cache, 'm/'.$value);
		if(!empty($memberSmiley))
		{
			$i++;
			file_put_contents($cache, '          	<div class="span2"><h4>'. $name . '</h4>' . "\n", FILE_APPEND);
			foreach($memberSmiley as $value)
			{
				file_put_contents($cache,'          		'. $value. "\n", FILE_APPEND);
			}
			file_put_contents($cache, '          	</div><!--user-->' . "\n", FILE_APPEND);
			$memberSmiley = array();
			if (!fmod($i,6)){
				file_put_contents($cache, '				</div><div class="row-fluid">' . "\n", FILE_APPEND);
			}
		}
	unset($memberDir);	
	}
}

function gencache($type) {
	$dirIgnore = array ('.','..', 'name.txt', 'hidden.txt');
	$cache = './cache/'. $type .'.cache';
	$dir = ($type === "carre") ? 'c' : 's' ;
	file_put_contents($cache, '		<!-- Cache -->'. "\n");
	file_put_contents($cache, '		<div class="span10">'. "\n", FILE_APPEND);
	// Bloc de 3
	file_put_contents($cache, '		<div class="row-fluid">'. "\n", FILE_APPEND);
	//Base
	file_put_contents($cache, '            <div class="span4">'. "\n", FILE_APPEND);
	file_put_contents($cache, '              <h2>Smilies de base</h2>'. "\n", FILE_APPEND);
	foreach(generate_folder($dir, $type, $cache, 'b') as $value)
			{
				file_put_contents($cache, $value. "\n", FILE_APPEND);
			}
	file_put_contents($cache, '              </div><!--/span-->'. "\n", FILE_APPEND);
	// Spéciaux
	file_put_contents($cache, '            <div class="span4">'. "\n", FILE_APPEND);
	file_put_contents($cache, '				<h2>Smilies</h2>'. "\n", FILE_APPEND);
	foreach(generate_folder($dir, $type, $cache, 's') as $value)
			{
				file_put_contents($cache, $value. "\n", FILE_APPEND);
			}
	file_put_contents($cache, '              </div><!--/span-->'. "\n", FILE_APPEND);
	// Autres
	file_put_contents($cache, '            <div class="span4">'. "\n", FILE_APPEND);
	file_put_contents($cache, '              <h2>Other smilies</h2>'. "\n", FILE_APPEND);
	foreach(generate_folder($dir, $type, $cache, 'a') as $value)
			{
				file_put_contents($cache, $value. "\n", FILE_APPEND);
			}
	file_put_contents($cache, '              </div><!--/span-->'. "\n", FILE_APPEND);
	file_put_contents($cache, '          </div><!--/row-->'. "\n", FILE_APPEND);
	file_put_contents($cache, '          <hr>'. "\n", FILE_APPEND);
	// Passons aux membres
	file_put_contents($cache, '          <div class="row-fluid">'. "\n", FILE_APPEND);
	generate_members($dir,$type,$cache);

	// row de fin des membres
	file_put_contents($cache, '          </div><!--/row-->'. "\n", FILE_APPEND);
	// div de fin
	file_put_contents($cache, '		</div><!--/span-->'. "\n", FILE_APPEND);
	file_put_contents($cache, '		<!-- End Of Cache -->'. "\n" , FILE_APPEND);
	//rien après
}