-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2015 at 06:52 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dnp_articles`
--

CREATE TABLE IF NOT EXISTS `dnp_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8_unicode_ci,
  `meta_desc` text COLLATE utf8_unicode_ci,
  `ordering` int(11) DEFAULT '0',
  `featured` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dnp_articles`
--

INSERT INTO `dnp_articles` (`id`, `category_id`, `title`, `identifier`, `description`, `photo`, `meta_key`, `meta_desc`, `ordering`, `featured`, `created`, `modified`, `status`) VALUES
(1, 1, 'Our participation at Dhaka Int Trade fair 2013', 'our-participation-at-dhaka-int-trade-fair-2013', '<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>', '1403012837_news-sample-img3.jpg', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1, 'no', '2014-06-22 06:28:30', '2015-04-12 13:10:23', 'active'),
(3, 1, 'Dealers tours of Europe', 'dealers-tours-of-europe', '<p><span>Europe Tour for "Dhamaka Offer".&nbsp;To demonstrate the concreteness of this ethical orientation, Pedrollo has chosen to apply particularly advantageous terms of sale in the conviction that water isn&rsquo;t an ordinary merchandise to draw profit from but&nbsp;</span><strong class="evidenza-nero">a special resource that must be guaranteed to everyone</strong><span>.</span></p>', '1403012703_news-sample-img2.jpg', '', '', 2, 'no', '2014-06-22 06:38:04', '2014-08-19 07:56:02', 'active'),
(4, 1, 'Pedrollo New Outlet at Comilla', 'pedrollo-new-outlet-at-comilla', '<p>Pedrollo Has launch a new&nbsp;outlet at comilla Naj Mansion,25.&nbsp;In this way the company tangibly manifests a form of sincere respect towards those most in need of solidarity and attention.</p>\r\n<p>Pedrollo also designs and manufactures the best possible product in terms of efficiency, reliability and guaranteed originality: a result it strives for through the continuing commitment of its&nbsp;<a href="http://www.pedrollo.com/cms/ENG/company-innovation.html"><strong>research and development division</strong></a>. It is precisely to ensure the constant improvement of its processes and products that, ever since its founding, Pedrollo SpA has&nbsp;<strong class="evidenza-nero">invested all the profits generated by its activity back into the company</strong>. This, too, is a real form of respect: towards customers and suppliers</p>', '1403012404_news-sample-img1.jpg', '', '', 3, 'no', '2014-06-22 06:38:43', '2014-08-19 08:05:25', 'active'),
(5, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ', 'lorem-ipsum-dolor-sit-amet,-consectetur-adipiscing-elit.-', '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida dignissim velit, id venenatis lacus condimentum vitae. Proin felis lorem, elementum a ligula eu, volutpat bibendum nulla. Donec lorem diam, condimentum sit amet aliquam in, placerat id purus. Pellentesque mollis elit et tellus malesuada lobortis. Cras tempus nisl urna, ut sollicitudin massa vestibulum a. Vivamus dignissim libero at velit feugiat, quis lacinia mauris venenatis. Donec convallis felis ante, nec scelerisque nunc dapibus ac. Cras ut feugiat ante. Praesent luctus lacus et tempor dapibus. Donec ullamcorper, mi sed aliquam tincidunt, mi velit ullamcorper justo, ut dapibus sapien nibh sit amet velit. Fusce ac convallis felis, vitae tincidunt eros. Donec sagittis mauris et erat ornare feugiat. Duis feugiat non lectus vehicula posuere. Aenean ultrices nisl aliquet bibendum tristique. Suspendisse quis purus in nibh ornare viverra ut eget magna. Sed fermentum lorem sed orci tristique, ut rutrum metus pharetra.</span></p>', '1408367314Penguins.jpg', 'hello', 'hello', 1, 'no', '2014-08-18 13:08:34', '2014-08-19 08:34:23', 'active'),
(6, 1, 'Nullam ante lorem dd', 'nullam-ante-lorem-dd', '<p>Nullam ante lorem, egestas nec dapibus vel, congue sed quam. Cras convallis arcu sit amet risus maximus, et consectetur erat porttitor. Donec eget erat sit amet ligula rutrum ullamcorper vel et mi. Aenean interdum quis elit malesuada pulvinar. In laoreet nisl et odio condimentum efficitur. Sed tristique pulvinar scelerisque. Praesent pretium, lorem et congue elementum, mi neque pulvinar mauris, in pharetra augue turpis id dolor. Suspendisse ipsum ante, dignissim imperdiet rhoncus eu, posuere at quam. Nunc tempor enim nibh, nec malesuada purus porta vel. Aliquam aliquet, diam quis iaculis tempus, lorem libero consectetur ligula, et volutpat nunc lorem quis nunc. Nulla dignissim mauris massa, at posuere turpis rutrum sit amet. Donec posuere faucibus est egestas vehicula. Donec purus turpis, condimentum ut congue rutrum, dictum in mauris. Cras et mi mattis, mollis felis eu, rutrum dolor. Pellentesque pulvinar mattis metus in imperdiet. Maecenas gravida enim sed efficitur laoreet.dd</p>', '1428568094_Penguins.jpg', 'afasdd', 'xbvxcdd', 113, 'yes', '2015-04-09 08:08:43', '2015-04-09 08:28:14', 'active'),
(8, 3, 'Ut ultrices erat vitae', 'ut-ultrices-erat-vitae', '<p>Ut ultrices erat vitae neque consectetur, sed imperdiet est dictum. Maecenas vulputate erat id sapien lobortis, tincidunt suscipit felis egestas. Aliquam lacinia neque sit amet gravida congue. Sed at dictum urna. Vivamus ornare ipsum non ligula finibus bibendum. Ut blandit pharetra leo, nec maximus arcu mollis et. Integer dignissim augue sit amet tellus fermentum porttitor. Donec libero eros, vulputate ut dolor sagittis, egestas rhoncus enim. Sed purus ex, molestie vitae purus congue, volutpat tincidunt nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam viverra magna sed urna rhoncus bibendum. Ut et elit ornare, interdum turpis id, dictum orci. Sed in lacus imperdiet, tempus velit eu, maximus leo.</p>', '1428567118Penguins.jpg', 'cbd', 'dfgdfsg', 22, 'yes', '2015-04-09 08:11:58', '2015-04-09 08:11:58', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_backup`
--

CREATE TABLE IF NOT EXISTS `dnp_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dnp_backup`
--

INSERT INTO `dnp_backup` (`id`, `version_comment`, `title`, `created_by`, `created`, `status`) VALUES
(1, 'Sample backup version 1', 'Array_2015-04-09-12-00-34-pm.sql', 'Administrator', '2015-04-09 12:00:34', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_banner_management`
--

CREATE TABLE IF NOT EXISTS `dnp_banner_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dnp_banner_management`
--

INSERT INTO `dnp_banner_management` (`id`, `title`, `caption`, `identifier`, `photo`, `ordering`, `created`, `modified`, `status`) VALUES
(1, 'Banner one', '<p>Public Relations, Publicity and Marketing</p>', 'banner-one', '1428743612slider1.jpg', 1, '2014-06-17 11:32:02', '2015-04-11 09:13:32', 'active'),
(2, 'Banner two', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>', 'banner-two', '1428743638slider2.jpg', 2, '2014-06-17 11:33:16', '2015-04-11 09:13:58', 'active'),
(3, 'sdfsa', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>', 'sdfsa', '1428743677slider3.jpg', 3, '2015-04-09 10:33:09', '2015-04-11 09:14:37', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_blocks`
--

CREATE TABLE IF NOT EXISTS `dnp_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_area_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `block_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dnp_blocks`
--

INSERT INTO `dnp_blocks` (`id`, `block_area_id`, `title`, `identifier`, `description`, `block_type`, `ordering`, `created`, `modified`, `status`) VALUES
(1, 1, 'Right sidebar block 1', 'right-sidebar-block-1', '<p><img src="http://localhost/shopimind/app/views/public/shopimind/layout/images/add-img1.jpg" alt="Add" /></p>', 'html', 1, '2013-12-28 11:34:46', '2013-12-30 06:56:18', 'active'),
(2, 1, 'Right sidebar block 2', 'right-sidebar-block-2', '<h2>Advertise</h2>\r\n<p><img src="http://localhost/shopimind/app/views/public/shopimind/layout/images/add-img1.jpg" alt="Add" /></p>\r\n<p>ac varius est luctus ac. Phasellus vel dui pellentesque, pretium leo eget, malesuada purus. Nunc tempus libero sit amet sapien egestas, eget porta massa</p>', 'html', 2, '2013-12-28 11:36:10', '2013-12-30 06:58:34', 'active'),
(3, 1, 'Right sidebar block 3', 'right-sidebar-block-3', '<h2>Integer eu sem enim</h2>\r\n<p>Integer eu sem enim. Fusce sagittis ligula non metus cursus fermentum. Nunc molestie eros vel lectus commodo, id vehicula purus convallis. Phasellus vitae consequat velit. Nunc non malesuada quam. Suspendisse scelerisque vehicula consequat. Sed sit amet est ut neque dictum mattis.</p>', 'html', 3, '2013-12-28 11:38:01', '2013-12-30 06:50:04', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_block_area`
--

CREATE TABLE IF NOT EXISTS `dnp_block_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='cms article table' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dnp_block_area`
--

INSERT INTO `dnp_block_area` (`id`, `title`, `identifier`, `description`, `created`, `modified`, `status`) VALUES
(1, 'Right sidebar area', 'right-sidebar-area', '', '2013-12-28 11:32:08', '2013-12-28 11:32:08', 'active'),
(2, 'Test Block area', 'test-block-area', '', '2015-04-09 08:51:44', '2015-04-09 08:51:44', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_categories`
--

CREATE TABLE IF NOT EXISTS `dnp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` text COLLATE utf8_unicode_ci,
  `meta_desc` text COLLATE utf8_unicode_ci,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dnp_categories`
--

INSERT INTO `dnp_categories` (`id`, `title`, `identifier`, `parent_id`, `description`, `photo`, `post_type`, `meta_key`, `meta_desc`, `ordering`, `created`, `modified`, `status`) VALUES
(1, 'Test Category one', 'test-category-one', 0, '<p>News</p>', NULL, 'category', NULL, NULL, 1, '2014-06-17 18:54:58', '2015-04-08 12:45:15', 'active'),
(2, 'Test Category Two', 'test-category-two', 0, '', NULL, 'category', '', '', 2, '2014-06-23 09:45:48', '2015-04-08 12:45:44', 'active'),
(3, 'Test Category Three', 'test-category-three', 0, '', NULL, 'category', '', '', 3, '2014-06-23 09:46:08', '2015-04-08 12:46:11', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_groups`
--

CREATE TABLE IF NOT EXISTS `dnp_groups` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_type` enum('admin','subscriber') NOT NULL DEFAULT 'subscriber',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('active','inactive','delete') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `dnp_groups`
--

INSERT INTO `dnp_groups` (`id`, `name`, `group_type`, `created`, `modified`, `status`) VALUES
(1, 'Superadmin', 'admin', '2015-04-07 06:25:43', '2015-04-07 06:25:43', 'active'),
(2, 'Developer', 'admin', '2015-04-07 06:25:50', '2015-04-07 06:25:50', 'active'),
(3, 'Article Editor', 'admin', '2015-04-07 06:25:55', '2015-04-07 06:25:55', 'active'),
(4, 'Subscriber', 'subscriber', '2015-04-07 06:26:01', '2015-04-07 06:26:01', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_menus`
--

CREATE TABLE IF NOT EXISTS `dnp_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dnp_menus`
--

INSERT INTO `dnp_menus` (`id`, `title`, `identifier`, `created`, `modified`, `status`) VALUES
(1, 'Header Menu', 'header-menu', '2014-06-19 13:19:36', '2014-06-19 13:19:36', 'active'),
(2, 'Footer Menu', 'footer-menu', '2014-06-19 13:19:44', '2014-06-19 13:19:44', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_menu_item`
--

CREATE TABLE IF NOT EXISTS `dnp_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `dnp_menu_item`
--

INSERT INTO `dnp_menu_item` (`id`, `menus_id`, `parent_id`, `title`, `identifier`, `menu_type`, `page_id`, `cat_id`, `url`, `target`, `ordering`, `created`, `modified`, `status`) VALUES
(1, 1, 0, 'About', 'about', 'page', '2', '', '', 'same', 1, '2015-04-11 11:00:49', '2015-04-11 11:00:49', 'active'),
(2, 1, 0, 'Press/Media', 'press/media', 'page', '3', '', '', 'same', 2, '2015-04-11 11:03:01', '2015-04-11 11:03:01', 'active'),
(3, 1, 0, 'Latest News', 'latest-news', 'page', '4', '', '', 'same', 3, '2015-04-11 11:03:16', '2015-04-11 11:03:16', 'delete'),
(4, 1, 0, 'Assets', 'assets', 'page', '5', '', '', 'same', 4, '2015-04-11 11:03:37', '2015-04-11 11:03:37', 'active'),
(5, 1, 0, 'Events', 'events', 'page', '6', '', '', 'same', 5, '2015-04-11 11:03:51', '2015-04-11 11:03:51', 'active'),
(6, 1, 0, 'Videos', 'videos', 'page', '7', '', '', 'same', 6, '2015-04-11 11:04:04', '2015-04-11 11:04:04', 'active'),
(7, 1, 0, 'Gallery', 'gallery', 'page', '8', '', '', 'same', 7, '2015-04-11 11:04:18', '2015-04-11 11:04:18', 'active'),
(8, 1, 0, 'Notable', 'notable', 'page', '9', '', '', 'same', 8, '2015-04-11 11:04:38', '2015-04-11 11:04:38', 'active'),
(9, 1, 0, 'Contact Us', 'contact-us', 'page', '10', '', '', 'same', 9, '2015-04-11 11:06:09', '2015-04-11 11:06:09', 'active'),
(10, 2, 0, 'About', 'about', 'page', '2', '', '', 'same', 1, '2015-04-11 11:10:41', '2015-04-11 11:10:41', 'active'),
(11, 2, 0, 'Press/Media', 'press/media', 'page', '3', '', '', 'same', 2, '2015-04-11 11:38:36', '2015-04-11 11:38:36', 'active'),
(12, 2, 0, 'Latest News', 'latest-news', 'page', '4', '', '', 'same', 3, '2015-04-11 11:38:54', '2015-04-11 11:38:54', 'active'),
(13, 2, 0, 'Assets', 'assets', 'page', '5', '', '', 'same', 4, '2015-04-11 11:39:10', '2015-04-11 11:39:10', 'active'),
(14, 2, 0, 'Events', 'events', 'page', '6', '', '', 'same', 5, '2015-04-11 11:39:26', '2015-04-11 11:39:26', 'active'),
(15, 2, 0, 'Videos', 'videos', 'page', '7', '', '', 'same', 6, '2015-04-11 11:39:41', '2015-04-11 11:39:41', 'active'),
(16, 2, 0, 'Gallery', 'gallery', 'page', '8', '', '', 'same', 7, '2015-04-11 11:39:54', '2015-04-11 11:39:54', 'active'),
(17, 2, 0, 'Notable', 'notable', 'page', '9', '', '', 'same', 8, '2015-04-11 11:40:09', '2015-04-11 11:40:09', 'active'),
(18, 2, 0, 'Contact Us', 'contact-us', 'page', '10', '', '', 'same', 9, '2015-04-11 11:40:19', '2015-04-11 11:40:19', 'active'),
(19, 2, 0, 'dfhgsdh', 'dfhgsdh', 'category', '', '3', '', 'same', 12, '2015-04-12 13:02:17', '2015-04-12 13:02:17', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_newslatter`
--

CREATE TABLE IF NOT EXISTS `dnp_newslatter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `status` enum('subscribe','unsubscribe','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'subscribe',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dnp_newslatter`
--

INSERT INTO `dnp_newslatter` (`id`, `email_address`, `created`, `status`) VALUES
(1, 'mrana@dropndot.com', '2013-12-19 06:39:27', 'subscribe'),
(2, 'user@gmail.com', '2013-12-19 06:40:08', 'subscribe');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_pages`
--

CREATE TABLE IF NOT EXISTS `dnp_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `layout` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dnp_pages`
--

INSERT INTO `dnp_pages` (`id`, `title`, `identifier`, `description`, `photo`, `controller`, `layout`, `meta_key`, `meta_desc`, `created`, `modified`, `status`) VALUES
(1, 'Home', 'home', '<p>Praesent mattis consectetur pulvinar. Maecenas ut interdum diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque posuere convallis enim, nec gravida nibh varius non. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras dictum, nisi et imperdiet pellentesque, ipsum augue commodo nisl, sit amet dapibus mauris lorem accumsan dui. Vivamus rutrum nisl nisi, id euismod sem laoreet in. Integer varius, sapien eu euismod aliquet, enim augue scelerisque neque, vel tincidunt risus turpis eu sapien. Nam sit amet vulputate justo. In feugiat erat in dolor pulvinar, quis efficitur nisi tincidunt. Suspendisse purus sapien, consequat a justo et, molestie lacinia mauris. Fusce eu tincidunt massa, in luctus sem. Suspendisse finibus ut nunc at luctus. Mauris scelerisque sapien a sapien efficitur aliquet. Fusce non hendrerit sapien. Curabitur blandit sagittis enim.</p>', '', 'sub_page', 'no', '', '', '2015-04-11 10:54:29', '2015-04-11 10:54:29', 'active'),
(2, 'About', 'about', '<h2 class="main-heading inner-header about">About tca Public Relations (TCA PR)</h2>\r\n<div class="about-inner  wow fadeInDown">\r\n<h2 class="heading">WHO WE ARE</h2>\r\n<p>The Communications Agency (TCA/TCAPR) - (Public Relations and Marketing Communications Group) is a full-service management consulting firm delivering Public Relations, Specialized Marketing Communications, Business Development and International Relations.</p>\r\n<p>The Communications Agency (TCA/TCAPR) - (Public Relations and Marketing Communications Group) is a full-service management consulting firm delivering Public Relations, Specialized Marketing Communications, Business Development and International Relations.</p>\r\n</div>\r\n<div class="about-inner  wow fadeInDown">\r\n<h2 class="heading">Public Relations</h2>\r\n<ul>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Reputation Management Public Relations</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Crisis Management Public Relations</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Media Relations Strategy</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Wealth and Financial Public Relations</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Publicity, Social Media and Digital Presentations</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Corporate Communications and Sponsorship Activation</a></li>\r\n</ul>\r\n</div>\r\n<div class="about-inner  wow fadeInDown">\r\n<h2 class="heading">MARKETING COMMUNICATIONS AND BRANDING:</h2>\r\n<ul>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Printing Services</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Product Launches</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Marketing and Promotional Events </a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Video Production</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Graphic Design</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Advertising Products &amp; Services</a></li>\r\n<li><em class="fa fa-angle-right"></em><a href="#">Advertorial Design</a></li>\r\n</ul>\r\n<p>Utilizing 20+ years of industry experience and functional expertise, TCA Public Relations and Marketing Consulting goes beyond the norm to develop new insights, drive results, and help grow your business. For more than 15 years TCA PR staff have been WORKER BEES behind some of the most recognized brands &amp; individuals in the businesses of: Nonprofit, Luxury Lifestyle, Entertainment, Corporate and Government.</p>\r\n<p>TCA staff has managed events and media campaigns with: First Lady Michelle Obama, Nancy Pelosi, Hillary Clinton, product launch campaigns with Fidelity Investments, Coca-Cola and Dodge, international financial development campaigns with World Bank Member countries and managed International Out of Country Voting Campaigns for the Governments of South Sudan and Iraq. We have also worked with many non profit organizations as fundraisers.</p>\r\n</div>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:57:00', '2015-04-11 12:30:54', 'active'),
(3, 'Press/Media', 'press/media', '<p>Mauris et odio vestibulum, lacinia urna ut, maximus felis. Nulla sed diam fringilla, imperdiet mi ac, hendrerit enim. Sed tincidunt odio nec elementum fermentum. Suspendisse posuere purus vitae eleifend bibendum. Donec porttitor molestie bibendum. Ut in arcu felis. Aenean in porttitor massa. Nullam commodo magna at arcu tincidunt feugiat. Nam fermentum ultrices odio, quis mollis est. Ut ultrices, orci nec porta ullamcorper, orci sapien aliquet massa, a ornare urna libero quis arcu.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:57:29', '2015-04-11 10:57:29', 'active'),
(4, 'Latest News', 'latest-news', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc commodo eros eu leo aliquet malesuada. Quisque quis diam consectetur, lobortis mauris non, convallis sem. Nunc auctor sed nisi a ullamcorper. Phasellus semper nisi non ligula eleifend, vel sodales mauris suscipit. Integer finibus turpis non efficitur consequat. Praesent vulputate facilisis mauris eu suscipit. Nullam vulputate, mi in lobortis vehicula, dui quam faucibus tortor, sed iaculis justo tortor nec orci. Duis eu ultrices felis. Duis est mauris, fringilla eu fringilla eu, malesuada at elit. In pellentesque turpis luctus, ornare erat et, vulputate tellus. Morbi sed mi rutrum, tempor enim nec, vulputate leo.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:58:30', '2015-04-11 10:58:30', 'active'),
(5, 'Assets', 'assets', '<p>Vivamus pulvinar vestibulum semper. Ut ut semper quam. Donec eget erat lobortis, ultrices nibh nec, efficitur leo. Ut mollis ultricies ipsum ac varius. Ut eu massa risus. Morbi ipsum quam, rhoncus eget accumsan posuere, facilisis vitae est. Nullam condimentum, mi vitae cursus fringilla, elit metus consequat augue, et tempus erat mi ut magna. Aliquam placerat, est non gravida imperdiet, mi mauris mattis odio, vitae lacinia erat ex non justo. Nullam in est vel massa porta porttitor non id ex.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:58:50', '2015-04-12 11:57:55', 'active'),
(6, 'Events', 'events', '<p>Vivamus pulvinar vestibulum semper. Ut ut semper quam. Donec eget erat lobortis, ultrices nibh nec, efficitur leo. Ut mollis ultricies ipsum ac varius. Ut eu massa risus. Morbi ipsum quam, rhoncus eget accumsan posuere, facilisis vitae est. Nullam condimentum, mi vitae cursus fringilla, elit metus consequat augue, et tempus erat mi ut magna. Aliquam placerat, est non gravida imperdiet, mi mauris mattis odio, vitae lacinia erat ex non justo. Nullam in est vel massa porta porttitor non id ex.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:59:05', '2015-04-11 10:59:05', 'active'),
(7, 'Videos', 'videos', '<p>Vivamus pulvinar vestibulum semper. Ut ut semper quam. Donec eget erat lobortis, ultrices nibh nec, efficitur leo. Ut mollis ultricies ipsum ac varius. Ut eu massa risus. Morbi ipsum quam, rhoncus eget accumsan posuere, facilisis vitae est. Nullam condimentum, mi vitae cursus fringilla, elit metus consequat augue, et tempus erat mi ut magna. Aliquam placerat, est non gravida imperdiet, mi mauris mattis odio, vitae lacinia erat ex non justo. Nullam in est vel massa porta porttitor non id ex.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:59:19', '2015-04-11 10:59:19', 'active'),
(8, 'Gallery', 'gallery', '<p>Mauris et odio vestibulum, lacinia urna ut, maximus felis. Nulla sed diam fringilla, imperdiet mi ac, hendrerit enim. Sed tincidunt odio nec elementum fermentum. Suspendisse posuere purus vitae eleifend bibendum. Donec porttitor molestie bibendum. Ut in arcu felis. Aenean in porttitor massa. Nullam commodo magna at arcu tincidunt feugiat. Nam fermentum ultrices odio, quis mollis est. Ut ultrices, orci nec porta ullamcorper, orci sapien aliquet massa, a ornare urna libero quis arcu.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 10:59:43', '2015-04-11 10:59:43', 'active'),
(9, 'Notable', 'notable', '<p>Mauris et odio vestibulum, lacinia urna ut, maximus felis. Nulla sed diam fringilla, imperdiet mi ac, hendrerit enim. Sed tincidunt odio nec elementum fermentum. Suspendisse posuere purus vitae eleifend bibendum. Donec porttitor molestie bibendum. Ut in arcu felis. Aenean in porttitor massa. Nullam commodo magna at arcu tincidunt feugiat. Nam fermentum ultrices odio, quis mollis est. Ut ultrices, orci nec porta ullamcorper, orci sapien aliquet massa, a ornare urna libero quis arcu.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 11:00:02', '2015-04-11 11:00:02', 'active'),
(10, 'Contact Us', 'contact-us', '<p>Mauris et odio vestibulum, lacinia urna ut, maximus felis. Nulla sed diam fringilla, imperdiet mi ac, hendrerit enim. Sed tincidunt odio nec elementum fermentum. Suspendisse posuere purus vitae eleifend bibendum. Donec porttitor molestie bibendum. Ut in arcu felis. Aenean in porttitor massa. Nullam commodo magna at arcu tincidunt feugiat. Nam fermentum ultrices odio, quis mollis est. Ut ultrices, orci nec porta ullamcorper, orci sapien aliquet massa, a ornare urna libero quis arcu.</p>', '', 'sub_page', 'yes', '', '', '2015-04-11 11:00:14', '2015-04-11 11:00:14', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_permission`
--

CREATE TABLE IF NOT EXISTS `dnp_permission` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `p_type_id` int(11) NOT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1742 ;

--
-- Dumping data for table `dnp_permission`
--

INSERT INTO `dnp_permission` (`per_id`, `group_id`, `p_type_id`, `permission`) VALUES
(197, 4, 1, 'a:1:{i:0;s:4:"read";}'),
(1171, 2, 1, 'a:1:{i:0;s:4:"read";}'),
(1172, 2, 2, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1173, 2, 3, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1174, 2, 4, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1175, 2, 5, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1176, 2, 6, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1177, 2, 7, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1178, 2, 8, 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}'),
(1179, 2, 9, 'a:1:{i:0;s:6:"backup";}'),
(1180, 2, 10, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1181, 2, 11, 'a:2:{i:0;s:3:"add";i:1;s:4:"edit";}'),
(1182, 2, 12, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1183, 2, 13, 'a:1:{i:0;s:4:"read";}'),
(1730, 1, 1, 'a:1:{i:0;s:4:"read";}'),
(1731, 1, 2, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1732, 1, 3, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1733, 1, 4, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1734, 1, 5, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1735, 1, 6, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1736, 1, 7, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1737, 1, 8, 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}'),
(1738, 1, 10, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1739, 1, 11, 'a:1:{i:0;s:4:"edit";}'),
(1740, 1, 12, 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}'),
(1741, 1, 13, 'a:1:{i:0;s:4:"read";}');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_permission_item`
--

CREATE TABLE IF NOT EXISTS `dnp_permission_item` (
  `p_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`p_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `dnp_permission_item`
--

INSERT INTO `dnp_permission_item` (`p_type_id`, `title`, `item_key`) VALUES
(1, 'Dashboard', 'dashboard'),
(2, 'Pages', 'pages'),
(3, 'Categories', 'categories'),
(4, 'Articles', 'articles'),
(5, 'Blocks', 'blocks'),
(6, 'Menus', 'menus'),
(7, 'Slider', 'slider'),
(8, 'Media Manager', 'media_manager'),
(9, 'Database Backup', 'database_backup'),
(10, 'User Role', 'user_role'),
(11, 'Settings', 'settings'),
(12, 'Users', 'users'),
(13, 'Newslatter', 'newslatter');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_settings`
--

CREATE TABLE IF NOT EXISTS `dnp_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `set_key` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `type` enum('text','textarea','image') COLLATE utf8_unicode_ci DEFAULT 'text',
  `component` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'core',
  PRIMARY KEY (`id`),
  UNIQUE KEY `set_key` (`set_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `dnp_settings`
--

INSERT INTO `dnp_settings` (`id`, `set_key`, `value`, `type`, `component`) VALUES
(1, 'admin_page_factor', '25', 'text', 'core'),
(2, 'public_page_factor', '10', 'text', 'core'),
(3, 'site_email', 'mrana@dropndot.com', 'text', 'core'),
(4, 'site_title', 'Dropnphp CMS', 'text', 'core'),
(5, 'site_meta_key', 'Welcome to Dropnphp CMS', 'textarea', 'core'),
(6, 'site_meta_description', '‘Dropnphp CMS’ Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vulputate mi a feugiat blandit. Nulla vel vehicula nibh. Nulla tempor turpis fermentum dignissim dignissim. Suspendisse enim quam, vehicula at mauris vel, iaculis efficitur massa. Nulla venenatis pretium felis, sit amet scelerisque elit porttitor a. Nullam suscipit congue pretium. Integer ornare sem nec ex faucibus, ullamcorper rhoncus tortor pulvinar. ', 'textarea', 'core'),
(7, 'site_lang', 'english', 'text', 'core'),
(8, 'public_theme', 'default', 'text', 'core'),
(9, 'site_url', 'http://localhost/cms/', 'text', 'core'),
(10, 'site_logo', '1428732872logo.png', 'image', 'core'),
(12, 'facebook_url', '#f', 'text', 'core'),
(13, 'twitter_url', '#t', 'text', 'core'),
(14, 'linkedin_url', '#l', 'text', 'core'),
(15, 'google_plus_url', '#g', 'text', 'core'),
(16, 'admin_site_logo', '1388565941ddlogo.png', 'image', 'core'),
(17, 'admin_footer_copy_right_txt', 'COPYRIGHT © 2014 <br /> <a href="http://dropndot.com">Dropndot.com </a><br /> All rights Reserved', 'textarea', 'core'),
(18, 'footer_txt', 'Copyright 2015. tcapublicrelations.com All rights reserved. <a target="_blank" href="#" title=""> Privacy Policy </a> | <a target="_blank" href="#" title="">Terms of Service</a>', 'text', 'core'),
(19, 'header_add_space', '1428748749add.jpg', 'image', 'core'),
(20, 'footer_logo', '1428753504logo-footer.png', 'image', 'core'),
(11, 'favicon_icon', '1428813803favicon.png', 'image', 'core');

-- --------------------------------------------------------

--
-- Table structure for table `dnp_users`
--

CREATE TABLE IF NOT EXISTS `dnp_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8_unicode_ci,
  `group_id` int(11) NOT NULL,
  `user_type` enum('admin','subscriber') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `status` enum('inactive','active','banned','hold','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'hold',
  `profile_image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `dnp_users`
--

INSERT INTO `dnp_users` (`id`, `name`, `location`, `email`, `username`, `password`, `created`, `phone`, `details`, `group_id`, `user_type`, `status`, `profile_image`) VALUES
(1, 'Administrator', 'Dropnphp - bangladesh', 'dropnphp@dropndot.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2013-12-05 21:18:09', '+8801718881499', 'Administrator details content.\r\n\r\nThanks', 1, 'admin', 'active', '1388410605ava-icon.png'),
(2, 'Masud Rana', 'Dhaka', 'rana@gmail.com', 'rana', '6e9454559ab0f65c702f78d553acab30', '2015-04-05 11:59:28', '123456', 'Details : ', 4, 'subscriber', 'active', '1428304446Photo2.jpg'),
(3, 'Mohasin', 'Dhaka', 'mohasin@gmail.com', 'mohasin', 'a30c3be50496773274d1800eb9f2d87e', '2015-04-05 12:06:41', '123456', 'Details : ', 4, 'admin', 'active', '1428304503p6.jpg'),
(4, 'Nur', '', 'nur@gmail.com', 'nur', 'b55178b011bfb206965f2638d0f87047', '2015-04-06 05:49:35', '658756', '', 3, 'admin', 'active', ''),
(5, 'Ruhul', '', 'ruhul@gmail.com', 'ruhul', '4427d63c392d1c24b6f72d7df7643e41', '2015-04-06 06:14:28', '6876976', '', 4, 'subscriber', 'active', ''),
(6, 'Kamrul Hasan', '', 'kamrul@gmail.com', 'kamrul', '3481fb769274abccd300e1516f252712', '2015-04-06 06:15:34', '4677456', '', 2, 'admin', 'active', ''),
(7, 'kamal', '', 'kamal@gmail.com', 'kamal', 'aa63b0d5d950361c05012235ab520512', '2015-04-06 06:16:40', '65768', '', 4, 'subscriber', 'active', '');
