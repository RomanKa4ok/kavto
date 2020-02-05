# Starter for SCSS
sass --watch scss/styles.scss:css/styles.min.css --style compressed

## Visual Studio Code
Add Extension: **Live Sass Compiler** <br/>
Add new setting: File -> Preferences -> Settings -> Live Sass Compiler <br/>
*"liveSassCompile.settings.formats": [
    {
        "format": "compressed",
        "extensionName": ".min.css",
        "savePath": "/css"
    }
],
"liveSassCompile.settings.autoprefix": [
    "> 1%",
    "last 2 versions"
]*


# MySQL DB
CREATE DATABASE kavto CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; <br>


create table requests
(
           id int auto_increment,
           name varchar(255) not null,
           phone_number varchar(20) not null,
           message text not null,
           status enum('new', 'resolved') default 'new' not null,
           constraint requests_pk
               primary key (id)
) CHARACTER SET=utf8;