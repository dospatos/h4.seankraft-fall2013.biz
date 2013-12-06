CREATE TABLE posts (
  post_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  post_text VARCHAR(160) NULL,
  created INT NULL,
  modified INT NULL,
  PRIMARY KEY(post_id, user_id),
  INDEX posts_FKIndex1(user_id)
);

CREATE TABLE posts_rivers (
  river_id INTEGER UNSIGNED NOT NULL,
  post_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(river_id, post_id),
  INDEX posts_rivers_FKIndex1(river_id)
);

CREATE TABLE rivers (
  river_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  river_name VARCHAR(100) NULL,
  river_class VARCHAR(10) NULL,
  descr VARCHAR(100) NULL,
  gps_coordinates_putin VARCHAR(50) NULL,
  gps_coordinates_takeout VARCHAR(50) NULL,
  created INT NULL,
  modified INT NULL,
  aw_river_id VARCHAR(50) NULL,
  PRIMARY KEY(river_id)
);

CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  created INT NULL,
  modified INT NULL,
  token VARCHAR(255) NULL,
  [password] VARCHAR(255) NULL,
  last_login INT NULL,
  time_zone VARCHAR(255) NULL,
  first_name VARCHAR(255) NULL,
  last_name VARCHAR(255) NULL,
  email VARCHAR(255) NULL,
  profile_text VARCHAR(255) NULL,
  location VARCHAR(255) NULL,
  avatar VARCHAR(255) NULL,
  PRIMARY KEY(user_id)
);

CREATE TABLE users_users (
  user_id INT NOT NULL,
  user_id_followed INT NOT NULL,
  created INT NULL,
  PRIMARY KEY(user_id, user_id_followed),
  INDEX users_following_FKIndex1(user_id)
);


