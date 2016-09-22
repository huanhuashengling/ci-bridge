-- MySQL Script generated by MySQL Workbench
-- Mon Sep 19 22:46:00 2016
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bridge
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bridge` ;

-- -----------------------------------------------------
-- Schema bridge
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bridge` DEFAULT CHARACTER SET utf8 ;
USE `bridge` ;

-- -----------------------------------------------------
-- Table `bridge`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`users` ;

CREATE TABLE IF NOT EXISTS `bridge`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(15) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `activation_code` VARCHAR(40) NULL DEFAULT NULL,
  `forgotten_password_code` VARCHAR(40) NULL DEFAULT NULL,
  `forgotten_password_time` INT(11) UNSIGNED NULL DEFAULT NULL,
  `remember_code` VARCHAR(40) NULL DEFAULT NULL,
  `created_on` INT(11) UNSIGNED NULL,
  `last_login` INT(11) UNSIGNED NOT NULL,
  `active` TINYINT(1) UNSIGNED NULL,
  `first_name` VARCHAR(50) NULL DEFAULT NULL,
  `last_name` VARCHAR(50) NULL DEFAULT NULL,
  `company` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`groups` ;

CREATE TABLE IF NOT EXISTS `bridge`.`groups` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`login_attempts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`login_attempts` ;

CREATE TABLE IF NOT EXISTS `bridge`.`login_attempts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(15) NOT NULL,
  `login` VARCHAR(100) NOT NULL,
  `time` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`users_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`users_groups` ;

CREATE TABLE IF NOT EXISTS `bridge`.`users_groups` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `group_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_groups_ users_idx` (`user_id` ASC),
  INDEX `fk_users_groups_groups1_idx` (`group_id` ASC),
  CONSTRAINT `fk_users_groups_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `bridge`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `bridge`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`classes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`classes` ;

CREATE TABLE IF NOT EXISTS `bridge`.`classes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `class_number` INT NOT NULL,
  `grade_number` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`grades` ;

CREATE TABLE IF NOT EXISTS `bridge`.`grades` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `grade_number` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`courses` ;

CREATE TABLE IF NOT EXISTS `bridge`.`courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `courses_number` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`parents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`parents` ;

CREATE TABLE IF NOT EXISTS `bridge`.`parents` (
  `users_id` INT UNSIGNED NOT NULL,
  `address` VARCHAR(45) NULL,
  PRIMARY KEY (`users_id`),
  INDEX `fk_parents_ users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_parents_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `bridge`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`students`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`students` ;

CREATE TABLE IF NOT EXISTS `bridge`.`students` (
  `users_id` INT UNSIGNED NOT NULL,
  `edu_starting_year` INT NOT NULL,
  `city_student_number` VARCHAR(19) NULL,
  `national_student_number` VARCHAR(19) NULL,
  `gender` INT NULL,
  `birth_date` DATETIME NULL,
  `classes_id` INT NOT NULL,
  `parents_users_id` INT UNSIGNED NULL,
  PRIMARY KEY (`users_id`),
  INDEX `fk_students_ users1_idx` (`users_id` ASC),
  INDEX `fk_students_classes1_idx` (`classes_id` ASC),
  INDEX `fk_students_parents1_idx` (`parents_users_id` ASC),
  CONSTRAINT `fk_students_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `bridge`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_students_classes1`
    FOREIGN KEY (`classes_id`)
    REFERENCES `bridge`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_students_parents1`
    FOREIGN KEY (`parents_users_id`)
    REFERENCES `bridge`.`parents` (`users_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`teachers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`teachers` ;

CREATE TABLE IF NOT EXISTS `bridge`.`teachers` (
  `users_id` INT UNSIGNED NOT NULL,
  `course_leader` VARCHAR(45) NULL,
  `class_teacher` VARCHAR(45) NULL,
  PRIMARY KEY (`users_id`),
  INDEX `fk_teachers_ users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_teachers_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `bridge`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`evaluation_indexs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`evaluation_indexs` ;

CREATE TABLE IF NOT EXISTS `bridge`.`evaluation_indexs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(100) NOT NULL,
  `last_update_date` DATETIME NULL,
  `last_updated_by` VARCHAR(45) NULL,
  `courses_id` INT NOT NULL,
  `order_number` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evaluation_index_courses1_idx` (`courses_id` ASC),
  CONSTRAINT `fk_evaluation_index_courses1`
    FOREIGN KEY (`courses_id`)
    REFERENCES `bridge`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`evaluation_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`evaluation_details` ;

CREATE TABLE IF NOT EXISTS `bridge`.`evaluation_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(100) NOT NULL,
  `last_update_date` DATETIME NULL,
  `last_updated_by` VARCHAR(45) NULL,
  `evaluation_indexs_id` INT NOT NULL,
  `order_number` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evaluation_detail_evaluation_index1_idx` (`evaluation_indexs_id` ASC),
  CONSTRAINT `fk_evaluation_detail_evaluation_index1`
    FOREIGN KEY (`evaluation_indexs_id`)
    REFERENCES `bridge`.`evaluation_indexs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`scores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`scores` ;

CREATE TABLE IF NOT EXISTS `bridge`.`scores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `score` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`evaluation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`evaluation` ;

CREATE TABLE IF NOT EXISTS `bridge`.`evaluation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `evaluate_date` DATETIME NULL,
  `courses_id` INT NOT NULL,
  `evaluation_indexs_id` INT NOT NULL,
  `evaluation_details_id` INT NOT NULL,
  `scores_id` INT NOT NULL,
  `teachers_users_id` INT UNSIGNED NOT NULL,
  `students_users_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evaluation_courses1_idx` (`courses_id` ASC),
  INDEX `fk_evaluation_evaluation_index1_idx` (`evaluation_indexs_id` ASC),
  INDEX `fk_evaluation_evaluation_detail1_idx` (`evaluation_details_id` ASC),
  INDEX `fk_evaluation_scores1_idx` (`scores_id` ASC),
  INDEX `fk_evaluation_teachers1_idx` (`teachers_users_id` ASC),
  INDEX `fk_evaluation_students1_idx` (`students_users_id` ASC),
  CONSTRAINT `fk_evaluation_courses1`
    FOREIGN KEY (`courses_id`)
    REFERENCES `bridge`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_evaluation_index1`
    FOREIGN KEY (`evaluation_indexs_id`)
    REFERENCES `bridge`.`evaluation_indexs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_evaluation_detail1`
    FOREIGN KEY (`evaluation_details_id`)
    REFERENCES `bridge`.`evaluation_details` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_scores1`
    FOREIGN KEY (`scores_id`)
    REFERENCES `bridge`.`scores` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_teachers1`
    FOREIGN KEY (`teachers_users_id`)
    REFERENCES `bridge`.`teachers` (`users_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_students1`
    FOREIGN KEY (`students_users_id`)
    REFERENCES `bridge`.`students` (`users_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`course_training_goal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`course_training_goal` ;

CREATE TABLE IF NOT EXISTS `bridge`.`course_training_goal` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_number` INT NULL,
  `description` VARCHAR(45) NOT NULL,
  `courses_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_course_training_goal_courses1_idx` (`courses_id` ASC),
  CONSTRAINT `fk_course_training_goal_courses1`
    FOREIGN KEY (`courses_id`)
    REFERENCES `bridge`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`courses_teachers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`courses_teachers` ;

CREATE TABLE IF NOT EXISTS `bridge`.`courses_teachers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `courses_id` INT NOT NULL,
  `teachers_users_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_courses_teachers_courses1_idx` (`courses_id` ASC),
  INDEX `fk_courses_teachers_teachers1_idx` (`teachers_users_id` ASC),
  CONSTRAINT `fk_courses_teachers_courses1`
    FOREIGN KEY (`courses_id`)
    REFERENCES `bridge`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_teachers_teachers1`
    FOREIGN KEY (`teachers_users_id`)
    REFERENCES `bridge`.`teachers` (`users_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bridge`.`ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bridge`.`ci_sessions` ;

CREATE TABLE IF NOT EXISTS `bridge`.`ci_sessions` (
  `id` VARCHAR(40) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` BLOB NOT NULL)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `bridge`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (1, '192.168.10.10', 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, DEFAULT, 1, 'You', 'Wenjie', NULL, '13487564267');
INSERT INTO `bridge`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (2, '192.168.10.10', 'school', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'school@admin.com', NULL, NULL, NULL, NULL, NULL, DEFAULT, 1, NULL, NULL, NULL, NULL);
INSERT INTO `bridge`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (3, '192.168.10.10', 'teacher', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'teacher@admin.com', NULL, NULL, NULL, NULL, NULL, DEFAULT, 1, NULL, NULL, NULL, NULL);
INSERT INTO `bridge`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (4, '192.168.10.10', 'student', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'student@admin.com', NULL, NULL, NULL, NULL, NULL, DEFAULT, 1, NULL, NULL, NULL, NULL);
INSERT INTO `bridge`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (5, '192.168.10.10', 'parent', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'parent@admin.com', NULL, NULL, NULL, NULL, NULL, DEFAULT, 1, NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`groups` (`id`, `name`, `description`) VALUES (1, 'admin', DEFAULT);
INSERT INTO `bridge`.`groups` (`id`, `name`, `description`) VALUES (2, 'school', DEFAULT);
INSERT INTO `bridge`.`groups` (`id`, `name`, `description`) VALUES (3, 'teacher', DEFAULT);
INSERT INTO `bridge`.`groups` (`id`, `name`, `description`) VALUES (4, 'student', DEFAULT);
INSERT INTO `bridge`.`groups` (`id`, `name`, `description`) VALUES (5, 'parent', DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`users_groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`users_groups` (`id`, `user_id`, `group_id`) VALUES (1, 1, 1);
INSERT INTO `bridge`.`users_groups` (`id`, `user_id`, `group_id`) VALUES (2, 2, 2);
INSERT INTO `bridge`.`users_groups` (`id`, `user_id`, `group_id`) VALUES (3, 3, 3);
INSERT INTO `bridge`.`users_groups` (`id`, `user_id`, `group_id`) VALUES (4, 4, 4);
INSERT INTO `bridge`.`users_groups` (`id`, `user_id`, `group_id`) VALUES (5, 5, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`classes`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (1, '一甲', 1, 1);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (2, '一乙', 2, 1);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (3, '一丙', 3, 1);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (4, '一丁', 4, 1);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (5, '二甲', 1, 2);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (6, '二乙', 2, 2);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (7, '二丙', 3, 2);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (8, '二丁', 4, 2);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (9, '三甲', 1, 3);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (10, '三乙', 2, 3);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (11, '三丙', 3, 3);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (12, '三丁', 4, 3);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (13, '四甲', 1, 4);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (14, '四乙', 2, 4);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (15, '四丙', 3, 4);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (16, '四丁', 4, 4);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (17, '五甲', 1, 5);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (18, '五乙', 2, 5);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (19, '五丙', 3, 5);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (20, '五丁', 4, 5);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (21, '六甲', 1, 6);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (22, '六乙', 2, 6);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (23, '六丙', 3, 6);
INSERT INTO `bridge`.`classes` (`id`, `name`, `class_number`, `grade_number`) VALUES (24, '六丁', 4, 6);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`grades`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (1, '一', 1);
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (2, '二', 2);
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (3, '三', 3);
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (4, '四', 4);
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (5, '五', 5);
INSERT INTO `bridge`.`grades` (`id`, `name`, `grade_number`) VALUES (6, '六', 6);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`courses`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (1, 1, '语文');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (2, 2, '数学');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (3, 3, '英语');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (4, 4, '音乐');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (5, 5, '体育');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (6, 6, '美术');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (7, 7, '科学');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (8, 8, '信息');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (9, 9, '综合');
INSERT INTO `bridge`.`courses` (`id`, `courses_number`, `name`) VALUES (10, 10, '校本');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`parents`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`parents` (`users_id`, `address`) VALUES (5, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`students`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`students` (`users_id`, `edu_starting_year`, `city_student_number`, `national_student_number`, `gender`, `birth_date`, `classes_id`, `parents_users_id`) VALUES (4, 2011, NULL, NULL, 1, NULL, 2, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`teachers`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`teachers` (`users_id`, `course_leader`, `class_teacher`) VALUES (3, '1', '1');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`evaluation_indexs`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`evaluation_indexs` (`id`, `description`, `last_update_date`, `last_updated_by`, `courses_id`, `order_number`) VALUES (1, '阅读能力', NULL, NULL, 1, 1);
INSERT INTO `bridge`.`evaluation_indexs` (`id`, `description`, `last_update_date`, `last_updated_by`, `courses_id`, `order_number`) VALUES (2, '表达能力', NULL, NULL, 1, 2);
INSERT INTO `bridge`.`evaluation_indexs` (`id`, `description`, `last_update_date`, `last_updated_by`, `courses_id`, `order_number`) VALUES (3, '计算能力', NULL, NULL, 2, 1);
INSERT INTO `bridge`.`evaluation_indexs` (`id`, `description`, `last_update_date`, `last_updated_by`, `courses_id`, `order_number`) VALUES (4, '分析能力', NULL, NULL, 2, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`evaluation_details`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`evaluation_details` (`id`, `description`, `last_update_date`, `last_updated_by`, `evaluation_indexs_id`, `order_number`) VALUES (1, '读一本好书', NULL, NULL, 1, 1);
INSERT INTO `bridge`.`evaluation_details` (`id`, `description`, `last_update_date`, `last_updated_by`, `evaluation_indexs_id`, `order_number`) VALUES (2, '写日记', NULL, NULL, 2, 2);
INSERT INTO `bridge`.`evaluation_details` (`id`, `description`, `last_update_date`, `last_updated_by`, `evaluation_indexs_id`, `order_number`) VALUES (3, '乘法计算', NULL, NULL, 3, 3);
INSERT INTO `bridge`.`evaluation_details` (`id`, `description`, `last_update_date`, `last_updated_by`, `evaluation_indexs_id`, `order_number`) VALUES (4, '会解应用题', NULL, NULL, 4, 4);
INSERT INTO `bridge`.`evaluation_details` (`id`, `description`, `last_update_date`, `last_updated_by`, `evaluation_indexs_id`, `order_number`) VALUES (5, '读书分享会', NULL, NULL, 1, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`scores`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`scores` (`id`, `score`, `name`) VALUES (1, 2, '优');
INSERT INTO `bridge`.`scores` (`id`, `score`, `name`) VALUES (2, 1, '良');
INSERT INTO `bridge`.`scores` (`id`, `score`, `name`) VALUES (3, -1, '差');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bridge`.`courses_teachers`
-- -----------------------------------------------------
START TRANSACTION;
USE `bridge`;
INSERT INTO `bridge`.`courses_teachers` (`id`, `courses_id`, `teachers_users_id`) VALUES (1, 1, 3);
INSERT INTO `bridge`.`courses_teachers` (`id`, `courses_id`, `teachers_users_id`) VALUES (2, 2, 3);

COMMIT;

