<?php

class Sites extends GitsmDB {

  function getSiteByIp($ip){
    $site = array();
    $site['device'] = $this->db->Equipment("ManagementIp LIKE ? OR MgtToolIp LIKE ?", $ip, $ip)
    ->select("EnvCode, Hostname, DeviceType, DeviceClass, OutOfBand, Comments")
    ->fetch();

    $site['location'] = $this->db->PhysicalLocation("EnvCode = ?", $site['device']['EnvCode'])
    ->fetch();

    $site['businessUnit'] = $this->db->PhysicalLocationBu("EnvCode = ?", $site['device']['EnvCode'])
    ->select("BuName")
    ->fetch();

    $site['telephony'] = $this->db->TelecomInfo("EnvCode = ?", $site['EnvCode'])
    ->select("SiteCac, StationTotal, StationTypes, TelecomOfficeName")
    ->fetch();

    $site['building'] = $this->db->Building("BldgCode = ?", $site['EnvCode'])
    ->select("FullAddress, Zip")
    ->fetch();

    return $site;
  }
}
?>
