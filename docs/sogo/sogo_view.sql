CREATE VIEW `sogo_view` AS 
select concat(`vmail`.`account`.`username`,'@',`vmail`.`account`.`domain`) AS `c_uid`,concat(`vmail`.`account`.`username`,'@',`vmail`.`account`.`domain`) AS `c_name`,`vmail`.`account`.`password` AS `c_password`,`vmail`.`account`.`name` AS `c_cn`,concat(`vmail`.`account`.`username`,'@',`vmail`.`account`.`domain`) AS `mail`,`vmail`.`account`.`domain` AS `domain` from `vmail`.`account` where `vmail`.`account`.`calendar` = 1 and `vmail`.`account`.`active` = 1