CREATE DATABASE `final_project`;

CREATE TABLE `users`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` BOOLEAN NOT NULL
);

CREATE TABLE `quiz_attempts`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `quiz_id` INT UNSIGNED NOT NULL,
    `score` INT UNSIGNED NOT NULL,
    `taken_at` DATETIME NOT NULL
);

CREATE TABLE `questions`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `quiz_id` INT UNSIGNED NOT NULL,
    `question_text` VARCHAR(255) NOT NULL
);

CREATE TABLE `quizzes`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(255) NOT NULL
);

CREATE TABLE `options`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `question_id` INT UNSIGNED NOT NULL,
    `option_text` VARCHAR(255) NOT NULL,
    `is_correct` BOOLEAN NOT NULL
);

ALTER TABLE `quiz_attempts` ADD CONSTRAINT `quiz_attempts_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `quiz_attempts` ADD CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY(`quiz_id`) REFERENCES `quizzes`(`id`);

ALTER TABLE `options` ADD CONSTRAINT `options_question_id_foreign` FOREIGN KEY(`question_id`) REFERENCES `questions`(`id`);

ALTER TABLE `questions` ADD CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY(`quiz_id`) REFERENCES `quizzes`(`id`);
