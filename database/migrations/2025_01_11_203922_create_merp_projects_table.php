<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('merp_projects', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        DB::statement("
        CREATE TABLE IF NOT EXISTS `merp_projects` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `project_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `project_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `associated_institution` bigint(20) UNSIGNED DEFAULT NULL,
            `project_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `grant_id` bigint(20) UNSIGNED DEFAULT NULL,
            `sponsor_id` bigint(20) UNSIGNED DEFAULT NULL,
            `funding_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `funding_amount` double(12,2) DEFAULT NULL,
            `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
            `proposal_submission_date` date DEFAULT NULL,
            `pi` bigint(20) UNSIGNED DEFAULT NULL,
            `coordinator_id` bigint(20) UNSIGNED DEFAULT NULL,
            `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `start_date` date NOT NULL,
            `end_date` date NOT NULL,
            `fa_fee_exemption` tinyint(1) NOT NULL DEFAULT '0',
            `fa_percentage_fee` double(4,2) NOT NULL DEFAULT '0.00',
            `project_summary` longtext COLLATE utf8mb4_unicode_ci,
            `progress_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_by` bigint(20) UNSIGNED DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
            PRIMARY KEY (`id`)

          )
          "
        );
        DB::statement("
            INSERT INTO `merp_projects` (`id`, `project_category`, `project_type`, `associated_institution`, `project_code`, `name`, `grant_id`, `sponsor_id`, `funding_source`, `funding_amount`, `currency_id`, `proposal_submission_date`, `pi`, `coordinator_id`, `email`, `start_date`, `end_date`, `fa_fee_exemption`, `fa_percentage_fee`, `project_summary`, `progress_status`, `created_by`, `created_at`, `updated_at`, `admin_id`) VALUES
          (1, 'Project', 'Primary', NULL, 'COV-BANK', 'COV-BANK', NULL, NULL, 'MakBRC', 300000000.00, 1, NULL, 2, 171, NULL, '2022-01-01', '2024-12-31', 0, 0.00, 'COV-BANK', 'In Progress', 1, '2024-01-30 19:22:22', '2024-04-03 22:58:04', NULL),
          (2, 'Project', 'Primary', NULL, 'LEAP', 'Wellcome Leap Project', NULL, NULL, NULL, NULL, 2, NULL, 167, 166, NULL, '2023-11-01', '2024-06-30', 1, 15.00, 'Purpose of Funding: To increase access to gasless Laparoscopic Surgery through\nthe local Manufacturing of a Novel Laparoscopic Technology called KeySuite', 'In Progress', 1, '2024-02-19 17:01:51', '2025-01-06 13:36:23', NULL),
          (3, 'Project', 'Primary', NULL, 'PRESIDE ', 'GOU - PRESIDE ', NULL, 2, 'GOVERNMENT', 3000000.00, 1, NULL, NULL, NULL, NULL, '2024-01-01', '2024-05-24', 0, 0.00, 'NA', 'Completed', 11, '2024-02-19 17:02:41', '2024-05-28 21:45:35', NULL),
          (4, 'Project', 'Primary', NULL, 'POCUS', 'POCUS TB', NULL, 398, NULL, NULL, 2, NULL, 163, 332, NULL, '2024-01-01', '2024-12-31', 1, 8.00, 'Project/Study/Grant Summary', 'In Progress', 1, '2024-04-06 19:02:04', '2025-01-06 13:38:20', NULL),
          (5, 'Project', 'Primary', NULL, 'FEND TB Adult', 'FEND KLA / FEND TB Adult', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2022-10-05', '2025-06-01', 0, 0.00, 'NA', 'In Progress', 1, '2024-04-06 19:14:27', '2024-11-07 18:44:16', NULL),
          (6, 'Project', 'Primary', NULL, 'FEND Jinja', 'FEND Jinja', NULL, 433, NULL, 0.00, 2, NULL, 2, 332, NULL, '2023-10-31', '2025-05-06', 0, 0.00, 'NA', 'In Progress', 1, '2024-04-06 19:54:36', '2024-11-07 18:43:35', NULL),
          (7, 'Project', 'Primary', NULL, 'HALTING', 'HALTING', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2024-04-05', '2024-07-08', 1, 8.00, 'NA', 'In Progress', 1, '2024-04-06 22:06:41', '2025-01-06 13:37:30', NULL),
          (8, 'Project', 'Primary', NULL, 'TBRU', 'TBRU', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2023-09-06', '2025-02-06', 0, 0.00, 'NA', 'In Progress', 1, '2024-04-08 07:08:50', '2024-11-07 18:45:15', NULL),
          (9, 'Project', 'Primary', NULL, 'PREGART', 'PREGART', NULL, 433, NULL, NULL, 3, NULL, 221, 216, NULL, '2023-09-04', '2025-05-08', 1, 15.00, 'PREGART Study is a clinical trial that is looking at the safety and efficacy of Dolutegravir and EFV400 for pregnant and breastfeeding women. It is a randomized non-inferiority clinical trial that is currently being conducted at Mildmay Uganda Hospital and TASO Entebbe', 'In Progress', 1, '2024-04-08 08:18:06', '2025-01-06 13:34:50', NULL),
          (10, 'Project', 'Primary', NULL, 'ESKAPE', 'ESKAPE', NULL, 398, NULL, 1000.00, 3, NULL, 156, 155, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'ESKAPE', 'In Progress', 1, '2024-04-08 11:19:59', '2024-08-15 21:17:11', NULL),
          (11, 'Project', 'Primary', NULL, 'TB COMBO', 'TB COMBO', NULL, 398, NULL, 1000.00, 2, NULL, 2, 38, NULL, '2024-01-01', '2025-06-30', 1, 8.00, 'TB COMBO', 'In Progress', 1, '2024-04-08 11:25:40', '2025-01-15 14:46:46', NULL),
          (12, 'Project', 'Primary', NULL, 'TIR', 'TIR', NULL, 398, NULL, 1000.00, 2, NULL, 163, NULL, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'TIR', 'In Progress', 1, '2024-04-08 11:41:58', '2024-05-07 20:03:04', NULL),
          (13, 'Project', 'Primary', NULL, 'LIIT', 'LIIT', NULL, 435, NULL, 1000.00, 2, NULL, 30, 30, NULL, '2024-01-01', '2024-12-31', 1, 15.00, 'LIIT', 'In Progress', 1, '2024-04-08 11:51:15', '2025-01-06 13:34:17', NULL),
          (14, 'Project', 'Primary', NULL, 'SMART-PVD', 'SMART-PVD', NULL, 434, NULL, NULL, 1, NULL, 232, 233, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'SMART-PVD', 'In Progress', 1, '2024-04-09 04:33:00', '2024-05-14 21:34:35', NULL),
          (15, 'Project', 'Primary', NULL, 'AHRI', 'AHRI', NULL, 433, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'AHRI', 'Implementation', 1, '2024-04-10 19:42:46', '2024-04-10 19:42:46', NULL),
          (16, 'Project', 'Primary', NULL, 'THRIVE POST', 'THRIVE POST', NULL, 433, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'THRIVE POST', 'Implementation', 1, '2024-04-10 19:43:42', '2024-04-10 19:43:42', NULL),
          (17, 'Project', 'Primary', NULL, 'TEXAS CHILDREN', 'TEXAS CHILDREN', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'TEXAS CHILDREN', 'Implementation', 1, '2024-04-10 19:44:49', '2024-04-10 19:44:49', NULL),
          (18, 'Project', 'Primary', NULL, 'SPIDAAR', 'SPIDAAR AMR SURVEILLANCE', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'SPIDAAR AMR SURVEILLANCE', 'Implementation', 1, '2024-04-10 19:45:55', '2024-04-10 19:45:55', NULL),
          (19, 'Project', 'Primary', NULL, 'CBS Study', 'CBS Study', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'CBS Study', 'In Progress', 1, '2024-04-10 19:47:10', '2024-04-10 19:47:10', NULL),
          (20, 'Project', 'Primary', NULL, 'Co-Infections', 'Co-Infections Study', NULL, NULL, NULL, NULL, 2, NULL, 197, 41, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'Co-Infections', 'In Progress', 1, '2024-04-10 19:48:42', '2024-08-02 16:14:09', NULL),
          (21, 'Project', 'Primary', NULL, 'NOD Study', 'NOD Study', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'NOD Study', 'In Progress', 1, '2024-04-10 19:50:30', '2024-11-07 18:47:01', NULL),
          (22, 'Project', 'Non-Primary', NULL, 'WHO Standard', 'WHO Standard: Achieving Universal Access to Rapid Diagnostics', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'WHO Standard: Achieving Universal Access to Rapid Diagnostics', 'In Progress', 1, '2024-04-11 00:11:05', '2024-04-11 00:11:05', NULL),
          (23, 'Project', 'Non-Primary', NULL, 'Aflatoxin Scanner', 'Aflatoxin Scanner Project', NULL, 433, NULL, NULL, 1, NULL, 295, 295, NULL, '2024-01-01', '2024-12-31', 1, 8.00, 'Aflatoxin Scanner Project', 'In Progress', 1, '2024-04-11 00:12:24', '2025-01-06 13:35:49', NULL),
          (24, 'Project', 'Non-Primary', NULL, 'CAS', 'Connect Africa Scholarship Travel Grant (CAS)', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'Connect Africa Scholarship Travel Grant (CAS)', 'In Progress', 1, '2024-04-11 00:13:52', '2024-04-11 00:13:52', NULL),
          (25, 'Project', 'Non-Primary', NULL, 'TDR', 'TDR Project', NULL, 433, NULL, NULL, 2, NULL, 2, 23, NULL, '2024-01-01', '2024-12-01', 0, 0.00, 'TDR Project', 'In Progress', 1, '2024-04-11 00:15:18', '2024-09-23 17:06:15', NULL),
          (26, 'Project', 'Primary', NULL, 'Truenat SOS', 'Truenat SOS', NULL, 433, NULL, NULL, 2, NULL, 2, 299, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'Truenat SOS', 'In Progress', 1, '2024-04-11 00:27:25', '2024-12-18 18:51:12', NULL),
          (27, 'Project', 'Primary', NULL, 'IVD', 'IVD Project', NULL, 433, NULL, NULL, 2, NULL, 2, 23, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'IVD Project', 'Implementation', 1, '2024-04-11 00:28:56', '2024-08-15 14:45:55', NULL),
          (28, 'Project', 'Primary', NULL, 'MRSA', 'MRSA', NULL, 433, NULL, NULL, 2, NULL, 197, 41, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'MRSA', 'Implementation', 1, '2024-04-11 21:51:42', '2024-04-23 19:21:26', NULL),
          (29, 'Project', 'Primary', NULL, 'Nosoconial', 'Nosoconial', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'Nosoconial', 'In Progress', 1, '2024-04-11 22:24:31', '2024-04-11 22:24:31', NULL),
          (30, 'Project', 'Primary', NULL, 'Early Imaging', 'Early Imaging', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2024-01-01', '2024-12-31', 1, 8.00, 'Early Imaging', 'In Progress', 1, '2024-04-12 18:57:04', '2025-01-06 13:36:47', NULL),
          (31, 'Project', 'Primary', NULL, 'Waste Water', 'Waste Water', NULL, 433, NULL, NULL, 2, NULL, 163, 332, NULL, '2024-01-01', '2024-12-31', 1, 8.00, 'Waste Water', 'In Progress', 1, '2024-04-12 18:57:52', '2025-01-06 13:39:40', NULL),
          (32, 'Project', 'Primary', NULL, 'Large Urine', 'Large Urine', NULL, 433, NULL, NULL, 2, NULL, 163, 126, NULL, '2024-01-01', '2024-12-31', 0, 0.00, 'Large Urine', 'In Progress', 1, '2024-04-12 18:58:45', '2024-10-14 12:30:05', NULL),
          (33, 'Project', 'Primary', NULL, 'THEA-C19', 'THEA-C19', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'THEA-C19', 'In Progress', 1, '2024-04-15 19:10:01', '2024-04-15 19:10:01', NULL),
          (34, 'Project', 'Primary', NULL, 'TCH', 'TEXAS CHILDREN\'S HOSPITAL', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-01-01', '2024-12-31', 0, 0.00, 'Summary', 'In Progress', 1, '2024-05-15 21:51:17', '2024-05-15 21:51:17', NULL),
          (35, 'Project', 'Primary', NULL, 'CPAP', 'CPAP PROJECT', NULL, 433, NULL, NULL, 4, NULL, 167, 170, NULL, '2024-03-01', '2024-12-31', 0, 0.00, 'N/A', 'In Progress', 31, '2024-05-16 15:08:11', '2024-05-24 15:04:09', NULL),
          (36, 'Project', 'Primary', NULL, 'PREDICT', 'PREDICT', NULL, 433, NULL, NULL, 2, NULL, 2, 126, NULL, '2024-01-01', '2025-01-01', 0, 0.00, 'N/A', 'In Progress', 1, '2024-05-28 21:00:13', '2024-05-29 00:51:10', NULL),
          (37, 'Project', 'Primary', NULL, 'Baby Incubator', '10 Unit Baby Incubator', NULL, 434, NULL, NULL, 1, NULL, 278, 283, NULL, '2024-03-01', '2025-02-28', 1, 8.00, '10 Unit Baby Incubator', 'In Progress', 31, '2024-06-04 20:05:41', '2025-01-06 13:35:22', NULL),
          (38, 'Project', 'Primary', NULL, 'NeoNest Project', 'NeoNest Project', NULL, 433, NULL, 18880000.00, 1, NULL, 284, 285, NULL, '2024-06-01', '2024-12-31', 0, 0.00, 'NeoNest Project', 'In Progress', 31, '2024-06-05 16:52:18', '2024-09-24 19:13:37', NULL),
          (39, 'Project', 'Primary', NULL, 'NTRL', 'NTRL', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-01-01', '2026-01-01', 0, 0.00, 'N/A', 'In Progress', 1, '2024-06-19 15:41:59', '2024-06-19 15:41:59', NULL),
          (40, 'Project', 'Primary', NULL, 'IMPERIAL-ARUA COLLABORATION PROJECT', 'IMPERIAL-ARUA COLLABORATION PROJECT', NULL, 433, NULL, NULL, 3, NULL, 291, NULL, NULL, '2023-01-01', '2025-01-01', 0, 0.00, 'N/A', 'Implementation', 1, '2024-06-19 16:34:23', '2024-07-08 22:19:43', NULL),
          (41, 'Project', 'Primary', NULL, 'Western University', 'Western University', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2024-01-01', '2026-01-01', 0, 0.00, 'N/A', 'In Progress', 1, '2024-06-19 17:46:24', '2024-06-19 17:46:24', NULL),
          (42, 'Study', 'Non-Primary', NULL, 'PREFIT ', 'PREFIT', NULL, 433, NULL, NULL, 3, NULL, NULL, 62, NULL, '2021-01-01', '2025-12-31', 0, 0.00, 'Laboratory Services ', 'In Progress', 31, '2024-07-24 17:12:38', '2024-10-22 18:08:06', NULL),
          (43, 'Study', 'Non-Primary', NULL, 'STOOL4TB', 'STOOL4TB', NULL, 435, NULL, NULL, 3, NULL, NULL, 71, NULL, '2024-01-01', '2026-12-31', 0, 0.00, 'MakBRC performing Lab work', 'In Progress', 31, '2024-07-24 22:49:15', '2024-10-23 16:27:54', NULL),
          (44, 'Grant', 'Research', NULL, 'PCR -2 ', 'The PCR Study', NULL, 434, NULL, NULL, 1, '2023-06-30', 2, 171, NULL, '2024-01-01', '2024-09-30', 0, 0.00, 'PCR-2 Research and design ', 'expired', 31, '2024-07-31 14:30:47', '2024-10-23 21:45:32', NULL),
          (45, 'Study', 'Non-Primary', NULL, 'SURGICAL FRACTURE TABLE ', 'SURGICAL FRACTURE TABLE ', NULL, 433, NULL, NULL, 2, NULL, 308, 308, NULL, '2024-05-01', '2025-06-30', 0, 0.00, 'BME', 'Delayed', 31, '2024-07-31 17:52:17', '2024-09-18 20:32:51', NULL),
          (46, 'Project', 'Primary', NULL, 'PCR', 'PCR and Antibody Diagnosis Kits', NULL, 433, NULL, NULL, 2, NULL, 2, 171, NULL, '2021-01-01', '2025-12-31', 0, 0.00, 'N/A', 'Implementation', 1, '2024-08-05 16:14:45', '2024-08-09 20:40:06', NULL),
          (47, 'Project', 'Non-Primary', NULL, 'MIGOHILL', 'Establishing the Mayuge-Iganga One Health Living laboratory as an exemplar for equitable implementation of Global Health (MIGOHILL)', NULL, 433, NULL, 17300.00, 4, NULL, 244, 23, NULL, '2024-02-01', '2024-09-30', 0, 0.00, 'The project aims  to create a One Health Living Laboratory (OHLL), functioning as a dynamic\necosystem where we can comprehensively identify innovative solutions to global challenges\nthrough co-development and iterative testing of solutions that can be sustainably adopted by\nthe One Health community of Practice (OHCP) at scale.', 'In Progress', 31, '2024-08-15 23:46:38', '2024-10-21 20:31:27', NULL),
          (48, 'Project', 'Non-Primary', NULL, 'MakBRC-TDC-SA-08-24', 'MAKBRC- THE DOCTOR\'S CHAMBERS LIMITED', NULL, 433, NULL, 1425000.00, 1, NULL, NULL, NULL, NULL, '2024-08-01', '2029-08-30', 0, 0.00, 'paternity testing service agreement ', 'In Progress', 44, '2024-08-22 14:50:36', '2024-08-22 14:50:36', NULL),
          (49, 'Project', 'Non-Primary', NULL, 'MakBRC-CML-SA-08-24', 'MAKBRC-CITY MEDICALS LIMITED', NULL, 433, NULL, 1425000.00, 1, NULL, NULL, NULL, NULL, '2024-08-01', '2029-08-30', 0, 0.00, 'Paternity testing service contract.', 'In Progress', 44, '2024-08-22 15:00:41', '2024-08-22 15:00:41', NULL),
          (50, 'Project', 'Non-Primary', NULL, 'ASLM', 'AFRICAN SOCIETY FOR LABORATORY MEDCINE ', NULL, 433, NULL, NULL, 2, NULL, NULL, NULL, NULL, '2023-10-01', '2024-09-29', 0, 0.00, 'the purpose of the development of a training curriculum for\nthe preparation of Proficiency testing samples for the Xpert MTB/RIF test as set out in the Original Agreement.', 'In Progress', 31, '2024-08-23 23:00:04', '2024-08-23 23:00:04', NULL),
          (51, 'Project', 'Non-Primary', NULL, 'REFL PRO', 'CHILD AND FAMILY FOUNDATION, UGANDA', NULL, 433, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2024-06-15', '2025-07-15', 0, 0.00, 'SERVICE AGREEMENT FOR STORAGE OF SAMPLES', 'In Progress', 44, '2024-08-26 13:43:01', '2024-11-13 03:35:31', NULL),
          (52, 'Project', 'Non-Primary', NULL, 'NTRL/SRL SERVICES', 'NTRL/SRL SERVICES ', NULL, 433, NULL, NULL, 1, NULL, 2, 299, NULL, '2024-08-26', '2026-08-31', 0, 0.00, 'NTRL/SRL  PROJECT RUN BY MAKBRC-MOH COLLABORATION', 'In Progress', 44, '2024-08-26 15:34:26', '2024-12-18 19:01:10', NULL),
          (53, 'Project', 'Non-Primary', NULL, 'DEEP-NTM', 'DEEP-NTM Sanger-MAKBRC Research Collaboration', NULL, 408, NULL, NULL, 2, NULL, 38, 62, NULL, '2024-09-01', '2025-10-01', 0, 0.00, 'Pre-award phase ', 'Planning', 31, '2024-09-06 20:43:04', '2024-09-18 19:59:33', NULL),
          (54, 'Project', 'Primary', NULL, 'BGI- Parternity testing ', 'BGI_MakBRC', NULL, 433, NULL, NULL, 1, NULL, 329, 328, NULL, '2024-08-01', '2025-01-31', 0, 0.00, 'BGI-MakBRC collaboration ', 'In Progress', 44, '2024-09-18 14:57:36', '2024-10-01 19:08:41', NULL),
          (55, 'Project', 'Non-Primary', NULL, 'MoH - Tazania ', 'TB Connectivity ', NULL, 433, NULL, NULL, 2, NULL, 2, 23, NULL, '2024-09-23', '2025-09-23', 0, 0.00, 'N/A', 'Planning', 31, '2024-09-23 18:37:23', '2024-09-23 19:14:25', NULL),
          (56, 'Project', 'Primary', NULL, 'HALTING -2 ', 'Halting -2 ', NULL, 433, NULL, NULL, 2, NULL, 2, 332, NULL, '2024-10-01', '2025-09-30', 1, 8.00, 'Project ', 'In Progress', 31, '2024-10-15 01:46:01', '2025-01-06 13:37:17', NULL),
          (57, 'Project', 'Primary', NULL, 'T-CELL RECEPTOR', 'T-CELL RECECEPTOR ', NULL, 433, NULL, NULL, 2, NULL, 252, 53, NULL, '2024-09-01', '2025-08-31', 0, 0.00, 'Using the T- Cell Receptor ', 'Implementation', 31, '2024-10-15 14:52:31', '2025-01-15 17:15:39', NULL),
          (58, 'Project', 'Non-Primary', NULL, 'Capacity Building', 'CAPACITY BUILDING MOH', NULL, 434, NULL, 0.01, 2, NULL, 2, 23, NULL, '2024-10-01', '2024-12-31', 0, 0.00, 'Capacity Building ', 'In Progress', 44, '2024-10-24 19:21:45', '2024-10-26 21:19:24', NULL),
          (59, 'Project', 'Non-Primary', NULL, 'iMapp', 'Estrogen, immune activation and HIV persistence during pregnancy project ', NULL, 433, NULL, 161546.40, 2, NULL, 333, 53, NULL, '2024-11-01', '2025-02-10', 1, 15.00, 'Interplay between Estrogen, immune activation and HIV persistence during pregnancy', 'In Progress', 44, '2024-11-01 17:40:55', '2025-01-06 13:50:48', NULL),
          (60, 'Project', 'Non-Primary', NULL, 'BV-BLUE Kit ', 'Bacterial Vaginosis Blue Kit', NULL, 433, NULL, NULL, 1, NULL, 2, 23, NULL, '2024-03-01', '2025-06-30', 0, 0.00, 'Kit Validation ', 'In Progress', 31, '2024-11-14 21:19:12', '2024-11-14 21:27:09', NULL),
          (61, 'Project', 'Primary', NULL, 'ALL IN ONE ', 'ALL IN ONE – Integrated Actions in the Health, Sanitation, and Livestock Sectors to Address Epidemic-Prone Diseases with a One Health Approach', NULL, 433, NULL, 50312.09, 3, NULL, 2, 55, NULL, '2024-11-15', '2026-10-14', 0, 0.00, 'Integrated Actions in the Health, Sanitation, and Livestock Sectors to Address Epidemic-Prone Diseases with a One Health Approach', 'In Progress', 31, '2024-11-16 16:53:10', '2024-11-16 16:59:29', NULL),
          (62, 'Project', 'Non-Primary', NULL, 'SANTHE', 'SANTHE Travel Award', NULL, 433, NULL, 4340.00, 2, NULL, 252, 53, NULL, '2025-01-01', '2025-01-31', 1, 0.00, 'N/A', 'In Progress', 44, '2024-12-10 14:37:07', '2025-01-17 02:53:21', NULL),
          (63, 'Project', 'Primary', NULL, 'CDRF GLOBAL MAKBRC GRANT', 'Evaluating the clinical utility of a novel RNA-based assay for predicting  TB treatment outcomes and diagnosing paucibacillary TB', NULL, 433, NULL, 44282.70, 2, NULL, NULL, NULL, NULL, '2025-01-01', '2026-11-14', 1, 10.00, 'N/A', 'In Progress', 44, '2025-01-16 22:48:46', '2025-01-16 22:48:46', NULL);
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merp_projects');
    }
};
