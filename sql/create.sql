CREATE TABLE scene (
  sceneID int PRIMARY KEY AUTO_INCREMENT not null,
  assetID varchar(10) not null,
  assetType varchar(30) not null,
  filePath varchar(50) not null,
  texture varchar(50) not null,
  Px int,
  Py int,
  Pz int,
  rotation float(4,2),
  scale float(4,2)
)
CREATE TABLE assets (
  assetID varchar( 10 ) PRIMARY KEY NOT NULL ,
  assetType varchar( 30 ) NOT NULL ,
  filePath varchar( 50 ) NOT NULL ,
  description varchar( 50 ) NOT NULL ,
  dimension varchar( 30 ) NOT NULL ,
  vendor varchar( 50 ) NOT NULL ,
  contactPerson varchar( 30 ) NOT NULL ,
  contactNo varchar( 20 ) NOT NULL ,
  remarks varchar( 100 ) ,

)

CREATE TABLE calendar (
  eventID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title varchar( 30 ) NOT NULL ,
  date date NOT NULL ,
  start_time time,
  colour varchar( 10 ) NOT NULL ,
  location varchar( 30 ),
  agenda varchar( 50 )
)

CREATE TABLE programme (
  activityID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title varchar( 30 ) NOT NULL ,
  start_time time NOT NULL
)
