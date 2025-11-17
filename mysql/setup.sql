DROP DATABASE IF EXISTS student_passwords;
CREATE DATABASE student_passwords DEFAULT CHARACTER SET utf8mb4;
DROP USER IF EXISTS 'passwords_user'@'localhost';

CREATE USER 'passwords_user'@'localhost';
GRANT ALL ON student_passwords.* TO 'passwords_user'@'localhost';
USE student_passwords;

SET block_encryption_mode = 'aes-256-cbc';
SET @key_str = UNHEX(SHA2('who goes there', 512));
SET @init_vector = RANDOM_BYTES(16);

CREATE TABLE IF NOT EXISTS website (
   site_id      SMALLINT(8)  NOT NULL,
   site_name    VARCHAR(256) NOT NULL,
   domain       VARCHAR(256) NOT NULL,
   PRIMARY KEY (site_id)
);

CREATE TABLE IF NOT EXISTS user (
   user_id      SMALLINT(8)  NOT NULL,
   first_name   VARCHAR(128) NOT NULL,
   last_name    VARCHAR(128) NOT NULL,
   email        VARCHAR(128) NOT NULL,
   PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS password (
   site_id      SMALLINT(8)    NOT NULL,
   user_id      SMALLINT(8)    NOT NULL,
   username     VARCHAR(128)   NOT NULL,
   password     VARBINARY(256) NOT NULL,
   time_created TIMESTAMP      NOT NULL,
   comment      TEXT(256)      NOT NULL,
   PRIMARY KEY (site_id, user_id)
);

INSERT INTO website VALUES (1, 'Gmail', 'https://mail.google.com');
INSERT INTO website VALUES (2, 'Amazon', 'https://www.amazon.com');
INSERT INTO website VALUES (3, 'Twitter', 'https://twitter.com');

INSERT INTO user VALUES (1, 'Sean', 'Kelly', 'MachineG1R1@gmail.com');
INSERT INTO user VALUES (2, 'Matt', 'Stephenson', 'MattMetal12@yahoo.com');
INSERT INTO user VALUES (3, 'Johnny', 'Knoxville', 'KnoxKnoxWhosThere@gmail.com');
INSERT INTO user VALUES (4, 'Sebastian', 'Solace', 'FishExpert1993@gmail.com');
INSERT INTO user VALUES (5, 'Kyle', 'Kiske', 'Dipper236@yahoo.com');
INSERT INTO user VALUES (6, 'Frederick', 'Bulsara', 'VolcanicVIPER@yahoo.com');
INSERT INTO user VALUES (7, 'Donkey', 'Kong', 'KingOfTheJungle@gmail.com');
INSERT INTO user VALUES (8, 'Robert', 'De Niro', 'TheDeNiro@gmail.com');
INSERT INTO user VALUES (9, 'David', 'Martinez', 'NCLegend2077@gmail.com');
INSERT INTO user VALUES (10, 'Adam', 'Smasher', 'Boogeyman2010@yahoo.com');

INSERT INTO password VALUES (1, 1, 'SKelly', AES_ENCRYPT('NeonWhite22', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (1, 2, 'OrangeBlueWhoAreYou', AES_ENCRYPT('DrumAndBass11', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (1, 3, 'NotAGreatGrandpa', AES_ENCRYPT('BrokenBones999', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (3, 4, 'WasteManager25', AES_ENCRYPT('Documentation1500', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (2, 5, 'LightningAndIce', AES_ENCRYPT('Illyria010', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (2, 6, 'FireStarter', AES_ENCRYPT('Sugercoat623', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (1, 7, 'BananaExpert', AES_ENCRYPT('JungleBeat04', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (3, 8, 'KnownAsDeNiro', AES_ENCRYPT('Heat1995', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (1, 9, 'SandAndSpice', AES_ENCRYPT('Lucy2078', @key_str, @init_vector), NOW(), '');
INSERT INTO password VALUES (1, 10, 'TungstenBlock', AES_ENCRYPT('Arasaka2021', @key_str, @init_vector), NOW(), '');
