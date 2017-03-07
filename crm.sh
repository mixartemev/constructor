#!/usr/bin/env bash
#composer global require "fxp/composer-asset-plugin"
composer create-project --prefer-dist yiisoft/yii2-app-advanced object-cms
cd object-cms
php init --env=Development --overwrite=All

#set db ssettings

php yii migrate/create create_metro_table --fields="name:string(255):notNull" --interactive=0
php yii migrate/create create_complex_table --fields="name:string(255):notNull,metro:integer:foreignKey(metro),address:string(255),exploit_apartment_cost:decimal(11,2):unsigned,exploit_office_cost:decimal(11,2):unsigned,exploit_torg_cost:decimal(11,2):unsigned,description:string(255)" --interactive=0
php yii migrate/create create_tower_table --fields="name:string(255):notNull,complex_id:integer:foreignKey(complex),square:integer(6):unsigned,floor:smallInteger(2):unsigned,ceiling:decimal(3,1):unsigned" --interactive=0
php yii migrate/create create_object_table --fields="id:primaryKey:unsigned,name:string(255):notNull,tower_id:integer:foreignKey(tower),square:integer(6):unsigned,floor:smallInteger(2):unsigned,ceiling:decimal(3,1):unsigned,created_at:integer:notNull,updated_at:integer:notNull" --interactive=0


php yii migrate/create create_in_table   --fields="val:integer:notNull,from_id:integer:foreignKey(from),when:timestamp:defaultExpression('CURRENT_TIMESTAMP'),comment:string(255)" --interactive=0
php yii migrate/create create_to_table   --fields="name:string(255):notNull,parent_id:integer:foreignKey(to)" --interactive=0
php yii migrate/create create_out_table  --fields="val:integer:notNull,to_id:integer:foreignKey(to),when:timestamp:defaultExpression('CURRENT_TIMESTAMP'),comment:string(255)" --interactive=0

php yii gii/model --tableName=* --ns='frontend\models' --interactive=0

php yii gii/crud --modelClass='frontend\models\From' --interactive=0 --enablePjax --enableI18N --controllerClass='frontend\controllers\FromController' --viewPath=@frontend/views/from
php yii gii/crud --modelClass='frontend\models\In'   --interactive=0 --enablePjax --enableI18N --controllerClass='frontend\controllers\InController'   --viewPath=@frontend/views/in
php yii gii/crud --modelClass='frontend\models\To'   --interactive=0 --enablePjax --enableI18N --controllerClass='frontend\controllers\ToController'   --viewPath=@frontend/views/to
php yii gii/crud --modelClass='frontend\models\Out'  --interactive=0 --enablePjax --enableI18N --controllerClass='frontend\controllers\OutController'  --viewPath=@frontend/views/out