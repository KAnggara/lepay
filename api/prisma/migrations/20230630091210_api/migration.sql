-- CreateTable
CREATE TABLE `users` (
    `username` VARCHAR(100) NOT NULL,
    `name` VARCHAR(100) NULL,
    `token` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`token`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `devices` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `device_id` VARCHAR(100) NOT NULL,
    `status` ENUM('connected', 'disconnected') NOT NULL DEFAULT 'disconnected',
    `disconnected_at` TIMESTAMP NULL,
    `disconnected_reason` VARCHAR(100) NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `messages` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `trigger` VARCHAR(100) NOT NULL,
    `response` VARCHAR(100) NOT NULL,
    `state` BOOLEAN NULL DEFAULT false,
    `hardwareId` INTEGER NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `hardwares` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `state` BOOLEAN NOT NULL DEFAULT false,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `messages` ADD CONSTRAINT `messages_hardwareId_fkey` FOREIGN KEY (`hardwareId`) REFERENCES `hardwares`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
