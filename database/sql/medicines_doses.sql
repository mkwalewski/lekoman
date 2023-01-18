SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `medicines_doses`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `medicines_doses` VALUES (1, 1, 24, 24, 'everyday', 1);
INSERT INTO `medicines_doses` VALUES (2, 2, 30, 20, 'everyday', 1);
INSERT INTO `medicines_doses` VALUES (3, 3, 200, 100, 'everyday', 1);
INSERT INTO `medicines_doses` VALUES (4, 4, 60, 15, 'occasionally', 1);
