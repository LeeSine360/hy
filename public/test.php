<?php
<th lay-data="{field: 'id', width:80}">编号</th>
<th lay-data="{field: 'proName', width:180}">项目名称</th>
<th lay-data="{field: 'bidsName', width:100}">项目经理</th>
<th lay-data="{field: 'proNumber', width:90}">项目编号</th>
<th lay-data="{field: 'conNumber', width:90} ">合同编号</th>
<th lay-data="{field: 'comName', width: 180}">供应商名称</th>
<th lay-data="{field: 'conPrice', width: 100}">合同总价</th>
<th lay-data="{field: 'category', width: 180}">分类名称</th>

`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
`corporation_id` INT NOT NULL,
`project_id` INT(10) UNSIGNED NOT NULL,
`company_id` INT(10) UNSIGNED NOT NULL,
`project_manager_id` VARCHAR(20) NOT NULL,
`category_id` VARCHAR(45) NULL COMMENT '标签ID（有多个标签）',
`number` INT(3) UNSIGNED ZEROFILL NOT NULL COMMENT '合同编号',
`price` DECIMAL(15,2) NULL COMMENT '总价',
`total` INT(2) NULL COMMENT '合同份数',
`keep` INT(2) NULL COMMENT '合同公司留存份数',
`start_time` INT(10) UNSIGNED NOT NULL COMMENT '合同开始日期',
`end_time` INT(10) UNSIGNED NULL COMMENT '合同截止日期',
`remark` VARCHAR(200) NULL COMMENT '备注',

"SELECT
	SQL_CALC_FOUND_ROWS c.id,
	c.id as id,
	p.name as proName,
	(SELECT
		GROUP_CONCAT(m.name)
	 FROM manager m
	 WHERE FIND_IN_SET(m.id,pm.manager_id)
	) AS bidsName,
	p.number as proNumber,	
	c.number as conNumber,
	com.name as comName,
	c.price as conPrice,
	(SELECT
		GROUP_CONCAT(m.name)
	 FROM category cat
	 WHERE FIND_IN_SET(cat.category_id,ca.name)
	) AS caName,	
FROM
	contract c,
	project p,
	corporation cor,
	project_manager pm,	
	company com,								
	category ca
WHERE
	c.project_id = p.id AND
	c.corporation_id = cor.id AND
	c.company_id = com.id AND

ORDER BY c.id ASC
LIMIT $curr, $limit"