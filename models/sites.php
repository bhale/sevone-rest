<?php

class Sites extends GitsmDB {

  function getSiteByIp($inputip){

    $site = $this->findOne("SELECT Equipment.EnvCode, StreetAddress2, OfficeDescription, ArchitectureRule, PhysicalLocation.LocalContact, LocalContactPhoneNumber, OutboundQos, InboundQos, Equipment.Hostname, ManagementIp, MdfIdf, LocationInSite, DeviceType, DeviceClass, OutOfBand, Equipment.Comments,  PhysicalLocationBu.BuName FROM PhysicalLocation, Equipment, TelecomInfo, PhysicalLocationBu WHERE PhysicalLocation.EnvCode = Equipment.EnvCode AND (Equipment.ManagementIp = '".$inputip."' OR Equipment.MgtToolIp = '".$inputip."') AND (PhysicalLocation.EnvCode = PhysicalLocationBu.EnvCode)");
    $site['telephony'] = $this->findOne("SELECT SiteCac, StationTotal, StationTypes, TelecomOfficeName FROM TelecomInfo WHERE TelecomInfo.EnvCode = '" . $site['EnvCode'] ."'");
    $site['device'] = $this->findOne("SELECT SerialNumber, Vendor, Model FROM EquipmentComponent WHERE Hostname LIKE '".$site['hostname']."'");
    $site['building'] = $this->findOne("SELECT FullAddress, Zip FROM Building WHERE BldgCode LIKE '".$site['envcode']."'");

    return $site;
  }
}
?>
