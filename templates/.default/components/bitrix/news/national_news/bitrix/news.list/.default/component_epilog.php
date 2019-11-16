<?php
$curDir = SITE_SERVER_NAME.$APPLICATION->GetCurPage();
$APPLICATION->AddHeadString('<link rel="canonical" href="https://'.$curDir.'">',true);