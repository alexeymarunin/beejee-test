CREATE TABLE `users` (
  `id`            INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `login`         VARCHAR(32)                       NOT NULL,
  `password_hash` VARCHAR(40)                       NOT NULL
);

INSERT INTO `users` (`login`, `password_hash`) VALUES ('admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

CREATE TABLE `tasks` (
  `id`       INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `content`  VARCHAR(255)                      NOT NULL,
  `username` VARCHAR(100)                      NOT NULL,
  `email`    VARCHAR(100)                      NOT NULL,
  `status`   INTEGER(1) DEFAULT 0
);
