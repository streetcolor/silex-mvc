 LOAD DATA LOCAL INFILE
 '/Users/streetcolor/Sites/silex-mvc/web/csv/bdpm.csv'
INTO TABLE medicines
FIELDS
        TERMINATED BY ';'
        ENCLOSED BY ''
LINES
        STARTING BY ''
        TERMINATED BY '\n';
        
        
        
        ALTER TABLE `GWT`.`medicines` 
ADD COLUMN `id_medicine` INT(11) NOT NULL AUTO_INCREMENT FIRST,
ADD COLUMN `date_updated` DATETIME NULL AFTER `security`,
ADD COLUMN `date_created` DATETIME NULL AFTER `date_updated`,
ADD PRIMARY KEY (`id_medicine`);


UPDATE medicines SET date_created = NOW(), date_updated = NOW();

ALTER TABLE `GWT`.`medicines` 
CHANGE COLUMN `date_updated` `date_updated` DATETIME NOT NULL ,
CHANGE COLUMN `date_created` `date_created` DATETIME NOT NULL ;