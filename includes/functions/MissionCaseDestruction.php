<?php

/**
* MissionCaseDestruction.php
* Commencé Par Tom
* Terminé par juju67 et Moa666
* @version 1
* @copyright 2008
*/

function MissionCaseDestruction($FleetRow) {
   global $user, $phpEx, $ugamela_root_path, $pricelist, $lang, $resource, $CombatCaps;

   includeLang('system');

   if ($FleetRow['fleet_start_time'] <= time()) {

      if ($FleetRow['fleet_mess'] == 0) {

         if (!isset($CombatCaps[202]['sd'])) {

            message("<font color=\"red\">". $lang['sys_no_vars'] ."</font>", $lang['sys_error'], "fleet." . $phpEx, 2);

         }

         $QryTargetPlanet  = "SELECT * FROM {{table}} ";

         $QryTargetPlanet .= "WHERE ";

         $QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";

         $QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";

         $QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";

         $TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);

         $TargetUserID     = $TargetPlanet['id_owner'];

         $QryDepPlanet  = "SELECT * FROM {{table}} ";

         $QryDepPlanet .= "WHERE ";

         $QryDepPlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";

         $QryDepPlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";

         $QryDepPlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";

         $QryDepPlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";

         $DepPlanet     = doquery( $QryDepPlanet, 'planets', true);

         $DepName     = $DepPlanet['name'];



         $QryCurrentUser   = "SELECT * FROM {{table}} ";

         $QryCurrentUser  .= "WHERE ";

         $QryCurrentUser  .= "`id` = '". $FleetRow['fleet_owner'] ."';";

         $CurrentUser      = doquery($QryCurrentUser , 'users', true);

         $CurrentUserID    = $CurrentUser['id'];



         $QryTargetUser    = "SELECT * FROM {{table}} ";

         $QryTargetUser   .= "WHERE ";

         $QryTargetUser   .= "`id` = '". $TargetUserID ."';";

         $TargetUser       = doquery($QryTargetUser, 'users', true);



         $QryTargetTech    = "SELECT ";

         $QryTargetTech   .= "`military_tech`, `defence_tech`, `shield_tech` ";

         $QryTargetTech   .= "FROM {{table}} ";

         $QryTargetTech   .= "WHERE ";

         $QryTargetTech   .= "`id` = '". $TargetUserID ."';";



         $TargetTechno     = doquery($QryTargetTech, 'users', true);



         $QryCurrentTech   = "SELECT ";

         $QryCurrentTech  .= "`military_tech`, `defence_tech`, `shield_tech` ";

         $QryCurrentTech  .= "FROM {{table}} ";

         $QryCurrentTech  .= "WHERE ";

         $QryCurrentTech  .= "`id` = '". $CurrentUserID ."';";

         $CurrentTechno    = doquery($QryCurrentTech, 'users', true);



         for ($SetItem = 200; $SetItem < 500; $SetItem++) {

            if ($TargetPlanet[$resource[$SetItem]] > 0) {

               $TargetSet[$SetItem]['count'] = $TargetPlanet[$resource[$SetItem]];

            }

         }



         $TheFleet = explode(";", $FleetRow['fleet_array']);

         foreach($TheFleet as $a => $b) {

            if ($b != '') {

               $a = explode(",", $b);

               $CurrentSet[$a[0]]['count'] = $a[1];

            }

         }



         include_once($ugamela_root_path . 'includes/ataki.' . $phpEx);



         // Calcul de la duree de traitement (initialisation)

         $mtime        = microtime();

         $mtime        = explode(" ", $mtime);

         $mtime        = $mtime[1] + $mtime[0];

         $starttime    = $mtime;



         $walka        = walka($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno);



         // Calcul de la duree de traitement (calcul)

         $mtime        = microtime();

         $mtime        = explode(" ", $mtime);

         $mtime        = $mtime[1] + $mtime[0];

         $endtime      = $mtime;

         $totaltime    = ($endtime - $starttime);



         // Ce qu'il reste de l'attaquant

         $CurrentSet   = $walka["atakujacy"];

         // Ce qu'il reste de l'attaqué

         $TargetSet    = $walka["wrog"];

         // Le resultat de la bataille

         $FleetResult  = $walka["wygrana"];

         // Rapport long (rapport de bataille detaillé)

         $dane_do_rw   = $walka["dane_do_rw"];

         // Rapport court (cdr + unitées perdues)

         $zlom         = $walka["zlom"];



         $FleetArray   = "";

         $FleetAmount  = 0;

         $FleetStorage = 0;


         foreach ($CurrentSet as $Ship => $Count) {

            $FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];

            $FleetArray   .= $Ship.",".$Count['count'].";";

            $FleetAmount  += $Count['count'];

         }

         $TargetPlanetUpd = "";

         if (!is_null($TargetSet)) {

            foreach($TargetSet as $Ship => $Count) {

               $TargetPlanetUpd .= "`". $resource[$Ship] ."` = '". $Count['count'] ."', ";

            }

         }

         if ($FleetResult == "a") {
         //debut des probabilite de destruction
         //Nous y voila! l attaquant a gagne, nous allons voir ses chances de detruire la lune
            $destructionl1 = 100-sqrt($TargetPlanet['diameter']);
            $destructionl21 = $destructionl1*sqrt($CurrentSet['214']['count']);

            $destructionl2 = $destructionl21/1;//ici c est la sensibilite de la destruction 1 c est l equivalent d ogame a 12 on a environ 2% pour 1000 rip
         //maintenant qu on sait quelle chance tantons la destruction, faites vos jeux croupier
         //$chance = round($destructionl2); // En pourcentage
         if ($destructionl2 > 100)   {
                  $chance = '100';
                  }
               else   { 
                  $chance = round($destructionl2); // En pourcentage
                  }
         $tirage = mt_rand(0, 100);
         $probalune       = sprintf ($lang['sys_destruc_lune'], $chance);
              if($tirage <= $chance)   {
                      $resultat = '1'; // lune detruite
            $finmess = $lang['sys_destruc_reussi'];
         //destruction de la lune dabord dans la liste des planetes puis dans la liste des lunes et enfin dans la galaxie
         doquery("DELETE FROM {{table}} WHERE `id` = '". $TargetPlanet['id'] ."';", 'planets');

         $Qrydestructionlune  = "UPDATE {{table}} SET ";

         $Qrydestructionlune .= "`destruyed` = '1' ";

         $Qrydestructionlune .= "WHERE ";

         $Qrydestructionlune .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $Qrydestructionlune .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
         $Qrydestructionlune .= "`lunapos` = '". $FleetRow['fleet_end_planet'] ."' ";

         $Qrydestructionlune .= "LIMIT 1 ;";
         //$Qrydestructionlune .= ";";

         doquery( $Qrydestructionlune , 'lunas');

         $Qrydestructionlune2  = "UPDATE {{table}} SET ";

         $Qrydestructionlune2 .= "`id_luna` = '0' ";

         $Qrydestructionlune2 .= "WHERE ";

         $Qrydestructionlune2 .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $Qrydestructionlune2 .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
         $Qrydestructionlune2 .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";

         $Qrydestructionlune2 .= "LIMIT 1 ;";
         //$Qrydestructionlune2 .= ";";

         doquery( $Qrydestructionlune2 , 'galaxy');
         //la lune est detruite, alors on redirige les flottes sur la planete
                   $QryDetFleets1  = "UPDATE {{table}} SET ";

                   $QryDetFleets1 .= "`fleet_start_type` = '1' ";

                   $QryDetFleets1 .= "WHERE ";   

                   $QryDetFleets1 .= "`fleet_start_galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

                   $QryDetFleets1 .= "`fleet_start_system` = '". $FleetRow['fleet_end_system'] ."' AND ";

                   $QryDetFleets1 .= "`fleet_start_planet` = '". $FleetRow['fleet_end_planet'] ."' ";

                   $QryDetFleets1 .= ";";

                  doquery( $QryDetFleets1 , 'fleets');

                   $QryDetFleets2  = "UPDATE {{table}} SET ";

                   $QryDetFleets2 .= "`fleet_end_type` = '1' ";

                  $QryDetFleets2 .= "WHERE ";

                   $QryDetFleets2 .= "`fleet_end_galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

                   $QryDetFleets2 .= "`fleet_end_system` = '". $FleetRow['fleet_end_system'] ."' AND ";

                   $QryDetFleets2 .= "`fleet_end_planet` = '". $FleetRow['fleet_end_planet'] ."' ";

                   $QryDetFleets2 .= ";";

                   doquery( $QryDetFleets2 , 'fleets');

         //maintenant on va verifier si la vue du joueur n est pas calee sur la lune qui est detruite  
         if ($TargetUser['current_planet'] == $TargetPlanet['id']){
         $QryPlanet  = "SELECT * FROM {{table}} ";

         $QryPlanet .= "WHERE ";

         $QryPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $QryPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";

         $QryPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";

         $QryPlanet .= "`planet_type` = '1';";

         $Planet     = doquery( $QryPlanet, 'planets', true);

         $IDPlanet     = $Planet['id'];

                   $Qryvue  = "UPDATE {{table}} SET ";

                   $Qryvue .= "`current_planet` = '". $IDPlanet ."' ";

                  $Qryvue .= "WHERE ";

                   $Qryvue .= "`id` = '". $TargetUserID ."' ";

                   $Qryvue .= ";";

                   doquery( $Qryvue , 'users');
         }
                  }
         else          {
              $resultat = '0'; }// la lune a resistee
         //la lune a resistee, alors voyons les chances que les rip soient detruites
         $destructionrip = sqrt($TargetPlanet['diameter'])/2;
         //maintenant qu on sait quelle chance tantons la destruction, allez roule croupier
         $chance2 = round($destructionrip); // En pourcentage
         if ($resultat == 0) {                  
                  $tirage2 = mt_rand(0, 100);
                  $probarip       = sprintf ($lang['sys_destruc_rip'], $chance2);
                       if($tirage2 <= $chance2)   {
                               $resultat2 = ' detruite 1'; // RIP detruite
                     $finmess = $lang['sys_destruc_echec'];
                     doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
                  }
         else          {
                      $resultat2 = 'sauvees 0'; // les RIP sont saines et sauves
            $finmess = $lang['sys_destruc_null'];
            }}
         //fin 
         }

         $introdestruc       = sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);

         // Mise a jour de l'enregistrement de la planete attaquée

         $QryUpdateTarget  = "UPDATE {{table}} SET ";

         $QryUpdateTarget .= $TargetPlanetUpd;

         $QryUpdateTarget .= "`metal` = `metal` - '". $Mining['metal'] ."', ";

         $QryUpdateTarget .= "`crystal` = `crystal` - '". $Mining['crystal'] ."', ";

         $QryUpdateTarget .= "`deuterium` = `deuterium` - '". $Mining['deuter'] ."' ";

         $QryUpdateTarget .= "WHERE ";

         $QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";

         $QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";

         $QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";

         $QryUpdateTarget .= "LIMIT 1;";

         doquery( $QryUpdateTarget , 'planets');



         // Mise a jour du champ de ruine devant la planete attaquée

         $QryUpdateGalaxy  = "UPDATE {{table}} SET ";

         $QryUpdateGalaxy .= "`metal` = `metal` + '". $zlom['metal'] ."', ";

         $QryUpdateGalaxy .= "`crystal` = `crystal` + '". $zlom['crystal'] ."' ";

         $QryUpdateGalaxy .= "WHERE ";

         $QryUpdateGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";

         $QryUpdateGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";

         $QryUpdateGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";

         $QryUpdateGalaxy .= "LIMIT 1;";

         doquery( $QryUpdateGalaxy , 'galaxy');



         // Là on va discuter le bout de gras pour voir s'il y a moyen d'avoir une Lune !

         $FleetDebris      = $zlom['metal'] + $zlom['crystal'];

         $StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $zlom["atakujacy"]);

         $StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $zlom["wrog"]);

         $StrRuins         = sprintf ($lang['sys_gcdrunits'], $zlom["metal"], $lang['Metal'], $zlom['crystal'], $lang['Crystal']);

         $DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;

         $MoonChance       = $FleetDebris / 100000;

         if ($FleetDebris > 2000000) {

            $MoonChance = 20;

         }

         if ($FleetDebris < 100000) {

            $UserChance = 0;

            $ChanceMoon = "";

         } elseif ($FleetDebris >= 100000) {

            $UserChance = mt_rand(1, 100);

            $ChanceMoon       = sprintf ($lang['sys_moonproba'], $MoonChance);

         }



         if (($UserChance > 0) and ($UserChance <= $MoonChance) and $galenemyrow['id_luna'] == 0) {

            $TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );

            $GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);

         } elseif ($UserChance = 0 or $UserChance > $MoonChance) {

            $GottenMoon = "";

         }



         $AttackDate        = date("r", $FleetRow["fleet_start_time"]);

         $title             = sprintf ($lang['sys_destruc_title'], $AttackDate);

         $raport            = "<center><table><tr><td>". $title ."<br />";

         $zniszczony        = false;

         $a_zestrzelona     = 0;

         $AttackTechon['A'] = $CurrentTechno["military_tech"] * 10;

         $AttackTechon['B'] = $CurrentTechno["defence_tech"] * 10;

         $AttackTechon['C'] = $CurrentTechno["shield_tech"] * 10;

         $AttackerData      = sprintf ($lang['sys_attack_attacker_pos'], $CurrentUser["username"], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'] );

         $AttackerTech      = sprintf ($lang['sys_attack_techologies'], $AttackTechon['A'], $AttackTechon['B'], $AttackTechon['C']);



         $DefendTechon['A'] = $TargetTechno["military_tech"] * 10;

         $DefendTechon['B'] = $TargetTechno["defence_tech"] * 10;

         $DefendTechon['C'] = $TargetTechno["shield_tech"] * 10;

         $DefenderData      = sprintf ($lang['sys_attack_defender_pos'], $TargetUser["username"], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'] );

         $DefenderTech      = sprintf ($lang['sys_attack_techologies'], $DefendTechon['A'], $DefendTechon['B'], $DefendTechon['C']);



         foreach ($dane_do_rw as $a => $b) {

            $raport .= "<table border=1 width=100%><tr><th><br /><center>".$AttackerData."<br />".$AttackerTech."<table border=1>";

            if ($b["atakujacy"]['count'] > 0) {

               $raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";

               $raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";

               $raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";

               $raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";

               $raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";

               foreach ($b["atakujacy"] as $Ship => $Data) {

                  if (is_numeric($Ship)) {

                     if ($Data['count'] > 0) {

                        $raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";

                        $raport2 .= "<th>". $Data['count'] ."</th>";

                        $raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";

                        $raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";

                        $raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";

                     }

                  }

               }

               $raport1 .= "</tr>";

               $raport2 .= "</tr>";

               $raport3 .= "</tr>";

               $raport4 .= "</tr>";

               $raport5 .= "</tr>";

               $raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;

            } else {

               if ($a == 2) {

                  $a_zestrzelona = 1;

               }

               $zniszczony = true;

               $raport .= "<br />". $lang['sys_destroyed'];

            }



            $raport .= "</table></center></th></tr></table>";

            $raport .= "<table border=1 width=100%><tr><th><br /><center>".$DefenderData."<br />".$DefenderTech."<table border=1>";

            if ($b["wrog"]['count'] > 0) {

               $raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";

               $raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";

               $raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";

               $raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";

               $raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";

               foreach ($b["wrog"] as $Ship => $Data) {

                  if (is_numeric($Ship)) {

                     if ($Data['count'] > 0) {

                        $raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";

                        $raport2 .= "<th>". $Data['count'] ."</th>";

                        $raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";

                        $raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";

                        $raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";

                     }

                  }

               }

               $raport1 .= "</tr>";

               $raport2 .= "</tr>";

               $raport3 .= "</tr>";

               $raport4 .= "</tr>";

               $raport5 .= "</tr>";

               $raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;

            } else {

               $zniszczony = true;

               $raport .= "<br />". $lang['sys_destroyed'];

            }

            $raport .= "</table></center></th></tr></table>";



            if (($zniszczony == false) and !($a == 8)) {

               $AttackWaveStat    = sprintf ($lang['sys_attack_attack_wave'], floor($b["atakujacy"]["atak"]), floor($b["wrog"]["tarcza"]));

               $DefendWavaStat    = sprintf ($lang['sys_attack_defend_wave'], floor($b["wrog"]["atak"]), floor($b["atakujacy"]["tarcza"]));

               $raport           .= "<br /><center>".$AttackWaveStat."<br />".$DefendWavaStat."</center>";

            }

         }

         switch ($FleetResult) {

            case "a":

               $raport           .= $lang['sys_attacker_won'] ."<br />";

               $raport           .= $DebrisField ."<br />";
               $raport           .= $introdestruc ."<br />";
               $raport           .= $lang['sys_destruc_mess1'];
               $raport           .= $finmess ."<br />";

               $raport           .= $probalune ."<br />";

               $raport           .= $probarip ."<br />";

               break;

            case "r":

               $raport           .= $lang['sys_both_won'] ."<br />";

               $raport           .= $DebrisField ."<br />";
               $raport           .= $introdestruc ."<br />";

               $raport           .= $lang['sys_destruc_stop'] ."<br />";

               break;

            case "w":

               $raport           .= $lang['sys_defender_won'] ."<br />";

               $raport           .= $DebrisField ."<br />";
               $raport           .= $introdestruc ."<br />";

               $raport           .= $lang['sys_destruc_stop'] ."<br />";

               doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');

               break;

            default:

               break;

         }

         $SimMessage        = sprintf ($lang['sys_rapport_build_time'], $totaltime);

         $raport           .= $SimMessage ."</table>";



         $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

         $rid   = md5($raport);

         $QryInsertRapport  = "INSERT INTO {{table}} SET ";

         $QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";

         $QryInsertRapport .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";

         $QryInsertRapport .= "`id_owner2` = '". $TargetUserID ."', ";

         $QryInsertRapport .= "`rid` = '". $rid ."', ";

         $QryInsertRapport .= "`a_zestrzelona` = '". $a_zestrzelona ."', ";

         $QryInsertRapport .= "`raport` = '". addslashes ( $raport ) ."';";

         doquery( $QryInsertRapport , 'rw');



         // Colorisation du résumé de rapport pour l'attaquant

            $raport  = "<a href # OnClick=\"f( 'rw.php?raport=". $rid ."', '');\" >";

         $raport .= "<center>";

            if       ($FleetResult == "a") {

            $raport .= "<font color=\"green\">";

            } elseif ($FleetResult == "r") {

            $raport .= "<font color=\"orange\">";

            } elseif ($FleetResult == "w") {

            $raport .= "<font color=\"red\">";

         }

         $raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";

         $raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $zlom["atakujacy"] ."</font>";

         $raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .":". $zlom["wrog"] ."</font><br />" ;

                     $raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". $zlom['metal'] ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">". $zlom['crystal'] ."</font><br /></center>";



         $QryUpdateFleet  = "UPDATE {{table}} SET ";

         $QryUpdateFleet .= "`fleet_amount` = '". $FleetAmount ."', ";

         $QryUpdateFleet .= "`fleet_array` = '". $FleetArray ."', ";

         $QryUpdateFleet .= "`fleet_mess` = '1' ";

         $QryUpdateFleet .= "WHERE fleet_id = '". $FleetRow['fleet_id'] ."' ";

         $QryUpdateFleet .= "LIMIT 1 ;";

         doquery( $QryUpdateFleet , 'fleets');



         SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport );



         // Colorisation du résumé de rapport pour le defenseur

         $raport2  = "<a href # OnClick=\"f( 'rw.php?raport=". $rid ."', '');\" >";

         $raport2 .= "<center>";

         if       ($FleetResult == "a") {

            $raport2 .= "<font color=\"red\">";

         } elseif ($FleetResult == "r") {

            $raport2 .= "<font color=\"orange\">";

         } elseif ($FleetResult == "w") {

            $raport2 .= "<font color=\"green\">";

         }

         $raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";



         SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport2 );



      }



      // Retour de flotte (s'il en reste)

      $fquery = "";

      if ($FleetRow['fleet_end_time'] <= time()) {

         if (!is_null($CurrentSet)) {

            foreach($CurrentSet as $Ship => $Count) {

               $fquery .= "`". $resource[$Ship] ."` = `". $resource[$Ship] ."` + '". $Count['count'] ."', ";

            }

         } else {

            $fleet = explode(";", $FleetRow['fleet_array']);

            foreach($fleet as $a => $b) {

               if ($b != '') {

                  $a = explode(",", $b);

                  $fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";

               }

            }

         }



         doquery ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');

         if (!($FleetResult == "w")) {

            $QryUpdatePlanet  = "UPDATE {{table}} SET ";

            $QryUpdatePlanet .= $fquery;

            $QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";

            $QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";

            $QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";

            $QryUpdatePlanet .= "WHERE ";

            $QryUpdatePlanet .= "`galaxy` = ".$FleetRow['fleet_start_galaxy']." AND ";

            $QryUpdatePlanet .= "`system` = ".$FleetRow['fleet_start_system']." AND ";

            $QryUpdatePlanet .= "`planet` = ".$FleetRow['fleet_start_planet']." AND ";

            $QryUpdatePlanet .= "`planet_type` = ".$FleetRow['fleet_start_type']." LIMIT 1 ;";

            doquery( $QryUpdatePlanet, 'planets' );

         }

      }

   }

}



?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>