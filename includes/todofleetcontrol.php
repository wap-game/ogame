<?php
/**
 *
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// Fonctions deja 'au propre'
include($xnova_root_path . 'includes/functions/FlyingFleetHandler.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseAttack.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseStay.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseStayAlly.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseTransport.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseSpy.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseRecycling.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseDestruction.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseColonisation.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseExpedition.'.$phpEx);
include($xnova_root_path . 'includes/functions/SendSimpleMessage.'.$phpEx);
include($xnova_root_path . 'includes/functions/SpyTarget.'.$phpEx);
include($xnova_root_path . 'includes/functions/RestoreFleetToPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/StoreGoodsToPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckPlanetBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckPlanetUsedFields.'.$phpEx);
include($xnova_root_path . 'includes/functions/CreateOneMoonRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/CreateOnePlanetRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/InsertJavaScriptChronoApplet.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsTechnologieAccessible.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetBuildingTime.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetRestPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetElementPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetBuildingPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsElementBuyable.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckCookies.'.$phpEx);
include($xnova_root_path . 'includes/functions/ChekUser.'.$phpEx);
include($xnova_root_path . 'includes/functions/InsertGalaxyScripts.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyCheckFunctions.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowGalaxyRows.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetPhalanxRange.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetMissileRange.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowPos.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowPlanetName.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowMoon.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowDebris.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowUser.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowAlly.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyRowActions.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowGalaxySelector.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowGalaxyMISelector.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowGalaxyTitles.'.$phpEx);
include($xnova_root_path . 'includes/functions/GalaxyLegendPopup.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowGalaxyFooter.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetMaxConstructibleElements.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetElementRessources.'.$phpEx);
include($xnova_root_path . 'includes/functions/ElementBuildListBox.'.$phpEx);
include($xnova_root_path . 'includes/functions/ElementBuildListQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/FleetBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/DefensesBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/ResearchBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/BatimentBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckLabSettingsInQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/InsertBuildListScript.'.$phpEx);
include($xnova_root_path . 'includes/functions/AddBuildingToQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/HandleTechnologieBuild.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildingSavePlanetRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildingSaveUserRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/RemoveBuildingFromQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/CancelBuildingFromQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/SetNextQueueElementOnTop.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowTopNavigationBar.'.$phpEx);
include($xnova_root_path . 'includes/functions/SetSelectedPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/MessageForm.'.$phpEx);
include($xnova_root_path . 'includes/functions/PlanetResourceUpdate.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildFlyingFleetTable.'.$phpEx);
include($xnova_root_path . 'includes/functions/SendNewPassword.'.$phpEx);
include($xnova_root_path . 'includes/functions/HandleElementBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/UpdatePlanetBatimentQueueList.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsOfficierAccessible.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckInputStrings.'.$phpEx);
include($xnova_root_path . 'includes/functions/MipCombatEngine.'.$phpEx);
include($xnova_root_path . 'includes/functions/DeleteSelectedUser.'.$phpEx);
include($xnova_root_path . 'includes/functions/SortUserPlanets.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildFleetEventTable.'.$phpEx);
include($xnova_root_path . 'includes/functions/ResetThisFuckingCheater.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsVacationMode.'.$phpEx);

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>