-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 06, 2012 as 10:36 PM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `connan`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu`
--

CREATE TABLE IF NOT EXISTS `conn_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `name` text NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_menu`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu_fields`
--

CREATE TABLE IF NOT EXISTS `conn_menu_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `default` text NOT NULL,
  `options` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_menu_fields`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu_items`
--

CREATE TABLE IF NOT EXISTS `conn_menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL,
  `default` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `title` text NOT NULL,
  `name` text NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_menu_items`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu_types`
--

CREATE TABLE IF NOT EXISTS `conn_menu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `parent` int(11) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_menu_types`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu_types_fields`
--

CREATE TABLE IF NOT EXISTS `conn_menu_types_fields` (
  `field_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `conn_menu_types_fields`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_menu_values`
--

CREATE TABLE IF NOT EXISTS `conn_menu_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_menu_values`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_modules`
--

CREATE TABLE IF NOT EXISTS `conn_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `title` text NOT NULL,
  `module` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_modules`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_modules_fields`
--

CREATE TABLE IF NOT EXISTS `conn_modules_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `default` text NOT NULL,
  `options` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_modules_fields`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_modules_relations`
--

CREATE TABLE IF NOT EXISTS `conn_modules_relations` (
  `page` int(11) NOT NULL,
  `module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `conn_modules_relations`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_modules_values`
--

CREATE TABLE IF NOT EXISTS `conn_modules_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_modules_values`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_templates`
--

CREATE TABLE IF NOT EXISTS `conn_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL,
  `default` int(11) NOT NULL,
  `name` text NOT NULL,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `copyright` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_templates`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_users`
--

CREATE TABLE IF NOT EXISTS `conn_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_users`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_users_fields`
--

CREATE TABLE IF NOT EXISTS `conn_users_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `required` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `default` text NOT NULL,
  `options` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_users_fields`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_users_types`
--

CREATE TABLE IF NOT EXISTS `conn_users_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_users_types`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `conn_users_values`
--

CREATE TABLE IF NOT EXISTS `conn_users_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conn_users_values`
--

