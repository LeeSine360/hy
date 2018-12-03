<?php
"corpId":"1"
"proId":"1"
"bids":"1"
"type":"1"
"teamClassify":"0"
"name":""
"phone":""
"comId":"3"
"price":"200000"
"remark":"asdf "


CREATE TABLE IF NOT EXISTS `hy`.`reimbursement` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `project_manager_id` INT(10) UNSIGNED NOT NULL,
  `company_id` INT(10) UNSIGNED NULL DEFAULT 0,
  `team_id` INT(10) UNSIGNED NULL DEFAULT 0,
  `type` TINYINT(1) UNSIGNED NULL DEFAULT 0 COMMENT '报销单类型：1、材料、租赁、分包项目 2、人员工资 3、费用报销 4、无合同报销',
  `price` DECIMAL(15,2) NOT NULL DEFAULT '0.00' COMMENT '金额合计',
  `remark` VARCHAR(100) NULL COMMENT '备注',
  `create_time` INT(10) NOT NULL,
  `update_time` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY USING BTREE (`id`),
  INDEX `fk_hy_reimbursement_hy_team1_idx` (`team_id` ASC),
  INDEX `fk_reimbursement_company1_idx` (`company_id` ASC),
  INDEX `fk_reimbursement_project_manager1_idx` (`project_manager_id` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf16
COMMENT = '报销单'

CREATE TABLE IF NOT EXISTS `hy`.`team_info` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '组长姓名',
  `phone` VARCHAR(45) NOT NULL COMMENT '组长电话',
  `remark` VARCHAR(45) NOT NULL COMMENT '备注',
  `creat_time` INT(11) NOT NULL,
  `update_time` INT(11) NOT NULL,
  `team_name_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_team_info_team_name1_idx` (`team_name_id` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf16
COMMENT = '班组人员详细信息'

CREATE TABLE IF NOT EXISTS `hy`.`team_name` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '班组名称'

INSERT INTO `hy`.`team_name` (`name`) VALUES ('行管班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('钢筋工班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('泥工班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('木工班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('架工班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('防水班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('水电班组');
INSERT INTO `hy`.`team_name` (`name`) VALUES ('杂工班组');
