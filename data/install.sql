CREATE TABLE `users` (
  `id`            INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `login`         VARCHAR(32)                       NOT NULL,
  `password_hash` VARCHAR(32)                       NOT NULL
);

INSERT INTO `users` (`login`, `password_hash`) VALUES ('admin', '202cb962ac59075b964b07152d234b70');

CREATE TABLE `media` (
  `id`        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `mime_type` VARCHAR(50)                       NOT NULL,
  `width`     INTEGER(4)                        NOT NULL,
  `height`    INTEGER(4)                        NOT NULL,
  `size`      INTEGER(11)                       NOT NULL,
  `filename`  VARCHAR(255)                      NOT NULL
);
INSERT INTO `media` (`mime_type`, `width`, `height`, `size`, `filename`) VALUES ('image/png', 600, 600, 17445 , '/noimage.png');

CREATE TABLE `tasks` (
  `id`       INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `content`  VARCHAR(255)                      NOT NULL,
  `username` VARCHAR(100)                      NOT NULL,
  `email`    VARCHAR(100)                      NOT NULL,
  `media_id` INTEGER    DEFAULT 1,
  `status`   INTEGER(1) DEFAULT 0,
  FOREIGN KEY (media_id) REFERENCES media (id)
);
