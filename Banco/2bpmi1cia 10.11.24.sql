-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Nov-2024 às 00:56
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `2bpmi1cia`
--
CREATE DATABASE IF NOT EXISTS `2bpmi1cia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `2bpmi1cia`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriacnh`
--

CREATE TABLE `categoriacnh` (
  `id` int(1) NOT NULL,
  `categoria` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoriacnh`
--

INSERT INTO `categoriacnh` (`id`, `categoria`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'AB'),
(7, 'AC'),
(8, 'AD'),
(9, 'AE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(5) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `id_estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `id_estado`) VALUES
(1, 'Acrelândia', 1),
(2, 'Assis Brasil', 1),
(3, 'Brasiléia', 1),
(4, 'Bujari', 1),
(5, 'Capixaba', 1),
(6, 'Cruzeiro do Sul', 1),
(7, 'Epitaciolândia', 1),
(8, 'Feijó', 1),
(9, 'Jordão', 1),
(10, 'Mâncio Lima', 1),
(11, 'Manoel Urbano', 1),
(12, 'Marechal Thaumaturgo', 1),
(13, 'Plácido de Castro', 1),
(14, 'Porto Acre', 1),
(15, 'Porto Walter', 1),
(16, 'Rio Branco', 1),
(17, 'Rodrigues Alves', 1),
(18, 'Santa Rosa do Purus', 1),
(19, 'Sena Madureira', 1),
(20, 'Senador Guiomard', 1),
(21, 'Tarauacá', 1),
(22, 'Xapuri', 1),
(23, 'Água Branca', 2),
(24, 'Anadia', 2),
(25, 'Arapiraca', 2),
(26, 'Atalaia', 2),
(27, 'Barra de Santo Antônio', 2),
(28, 'Barra de São Miguel', 2),
(29, 'Batalha', 2),
(30, 'Belém', 2),
(31, 'Belo Monte', 2),
(32, 'Boca da Mata', 2),
(33, 'Branquinha', 2),
(34, 'Cacimbinhas', 2),
(35, 'Cajueiro', 2),
(36, 'Campestre', 2),
(37, 'Campo Alegre', 2),
(38, 'Campo Grande', 2),
(39, 'Canapi', 2),
(40, 'Capela', 2),
(41, 'Carneiros', 2),
(42, 'Chã Preta', 2),
(43, 'Coité do Nóia', 2),
(44, 'Colônia Leopoldina', 2),
(45, 'Coqueiro Seco', 2),
(46, 'Coruripe', 2),
(47, 'Craíbas', 2),
(48, 'Delmiro Gouveia', 2),
(49, 'Dois Riachos', 2),
(50, 'Estrela de Alagoas', 2),
(51, 'Feira Grande', 2),
(52, 'Feliz Deserto', 2),
(53, 'Flexeiras', 2),
(54, 'Girau do Ponciano', 2),
(55, 'Ibateguara', 2),
(56, 'Igaci', 2),
(57, 'Igreja Nova', 2),
(58, 'Inhapi', 2),
(59, 'Jacaré dos Homens', 2),
(60, 'Jacuípe', 2),
(61, 'Japaratinga', 2),
(62, 'Jaramataia', 2),
(63, 'Jequiá da Praia', 2),
(64, 'Joaquim Gomes', 2),
(65, 'Jundiá', 2),
(66, 'Junqueiro', 2),
(67, 'Lagoa da Canoa', 2),
(68, 'Limoeiro de Anadia', 2),
(69, 'Maceió', 2),
(70, 'Major Isidoro', 2),
(71, 'Mar Vermelho', 2),
(72, 'Maragogi', 2),
(73, 'Maravilha', 2),
(74, 'Marechal Deodoro', 2),
(75, 'Maribondo', 2),
(76, 'Mata Grande', 2),
(77, 'Matriz de Camaragibe', 2),
(78, 'Messias', 2),
(79, 'Minador do Negrão', 2),
(80, 'Monteirópolis', 2),
(81, 'Murici', 2),
(82, 'Novo Lino', 2),
(83, 'Olho d Água das Flores', 2),
(84, 'Olho d Água do Casado', 2),
(85, 'Olho d Água Grande', 2),
(86, 'Olivença', 2),
(87, 'Ouro Branco', 2),
(88, 'Palestina', 2),
(89, 'Palmeira dos Índios', 2),
(90, 'Pão de Açúcar', 2),
(91, 'Pariconha', 2),
(92, 'Paripueira', 2),
(93, 'Passo de Camaragibe', 2),
(94, 'Paulo Jacinto', 2),
(95, 'Penedo', 2),
(96, 'Piaçabuçu', 2),
(97, 'Pilar', 2),
(98, 'Pindoba', 2),
(99, 'Piranhas', 2),
(100, 'Poço das Trincheiras', 2),
(101, 'Porto Calvo', 2),
(102, 'Porto de Pedras', 2),
(103, 'Porto Real do Colégio', 2),
(104, 'Quebrangulo', 2),
(105, 'Rio Largo', 2),
(106, 'Roteiro', 2),
(107, 'Santa Luzia do Norte', 2),
(108, 'Santana do Ipanema', 2),
(109, 'Santana do Mundaú', 2),
(110, 'São Brás', 2),
(111, 'São José da Laje', 2),
(112, 'São José da Tapera', 2),
(113, 'São Luís do Quitunde', 2),
(114, 'São Miguel dos Campos', 2),
(115, 'São Miguel dos Milagres', 2),
(116, 'São Sebastião', 2),
(117, 'Satuba', 2),
(118, 'Senador Rui Palmeira', 2),
(119, 'Tanque d Arca', 2),
(120, 'Taquarana', 2),
(121, 'Teotônio Vilela', 2),
(122, 'Traipu', 2),
(123, 'União dos Palmares', 2),
(124, 'Viçosa', 2),
(125, 'Alvarães', 3),
(126, 'Amaturá', 3),
(127, 'Anamã', 3),
(128, 'Anori', 3),
(129, 'Apuí', 3),
(130, 'Atalaia do Norte', 3),
(131, 'Autazes', 3),
(132, 'Barcelos', 3),
(133, 'Barreirinha', 3),
(134, 'Benjamin Constant', 3),
(135, 'Beruri', 3),
(136, 'Boa Vista do Ramos', 3),
(137, 'Boca do Acre', 3),
(138, 'Borba', 3),
(139, 'Caapiranga', 3),
(140, 'Canutama', 3),
(141, 'Carauari', 3),
(142, 'Careiro', 3),
(143, 'Careiro da Várzea', 3),
(144, 'Coari', 3),
(145, 'Codajás', 3),
(146, 'Eirunepé', 3),
(147, 'Envira', 3),
(148, 'Fonte Boa', 3),
(149, 'Guajará', 3),
(150, 'Humaitá', 3),
(151, 'Ipixuna', 3),
(152, 'Iranduba', 3),
(153, 'Itacoatiara', 3),
(154, 'Itamarati', 3),
(155, 'Itapiranga', 3),
(156, 'Japurá', 3),
(157, 'Juruá', 3),
(158, 'Jutaí', 3),
(159, 'Lábrea', 3),
(160, 'Manacapuru', 3),
(161, 'Manaquiri', 3),
(162, 'Manaus', 3),
(163, 'Manicoré', 3),
(164, 'Maraã', 3),
(165, 'Maués', 3),
(166, 'Nhamundá', 3),
(167, 'Nova Olinda do Norte', 3),
(168, 'Novo Airão', 3),
(169, 'Novo Aripuanã', 3),
(170, 'Parintins', 3),
(171, 'Pauini', 3),
(172, 'Presidente Figueiredo', 3),
(173, 'Rio Preto da Eva', 3),
(174, 'Santa Isabel do Rio Negro', 3),
(175, 'Santo Antônio do Içá', 3),
(176, 'São Gabriel da Cachoeira', 3),
(177, 'São Paulo de Olivença', 3),
(178, 'São Sebastião do Uatumã', 3),
(179, 'Silves', 3),
(180, 'Tabatinga', 3),
(181, 'Tapauá', 3),
(182, 'Tefé', 3),
(183, 'Tonantins', 3),
(184, 'Uarini', 3),
(185, 'Urucará', 3),
(186, 'Urucurituba', 3),
(187, 'Amapá', 4),
(188, 'Calçoene', 4),
(189, 'Cutias', 4),
(190, 'Ferreira Gomes', 4),
(191, 'Itaubal', 4),
(192, 'Laranjal do Jari', 4),
(193, 'Macapá', 4),
(194, 'Mazagão', 4),
(195, 'Oiapoque', 4),
(196, 'Pedra Branca do Amapari', 4),
(197, 'Porto Grande', 4),
(198, 'Pracuúba', 4),
(199, 'Santana', 4),
(200, 'Serra do Navio', 4),
(201, 'Tartarugalzinho', 4),
(202, 'Vitória do Jari', 4),
(203, 'Abaíra', 5),
(204, 'Abaré', 5),
(205, 'Acajutiba', 5),
(206, 'Adustina', 5),
(207, 'Água Fria', 5),
(208, 'Aiquara', 5),
(209, 'Alagoinhas', 5),
(210, 'Alcobaça', 5),
(211, 'Almadina', 5),
(212, 'Amargosa', 5),
(213, 'Amélia Rodrigues', 5),
(214, 'América Dourada', 5),
(215, 'Anagé', 5),
(216, 'Andaraí', 5),
(217, 'Andorinha', 5),
(218, 'Angical', 5),
(219, 'Anguera', 5),
(220, 'Antas', 5),
(221, 'Antônio Cardoso', 5),
(222, 'Antônio Gonçalves', 5),
(223, 'Aporá', 5),
(224, 'Apuarema', 5),
(225, 'Araças', 5),
(226, 'Aracatu', 5),
(227, 'Araci', 5),
(228, 'Aramari', 5),
(229, 'Arataca', 5),
(230, 'Aratuípe', 5),
(231, 'Aurelino Leal', 5),
(232, 'Baianópolis', 5),
(233, 'Baixa Grande', 5),
(234, 'Banzaê', 5),
(235, 'Barra', 5),
(236, 'Barra da Estiva', 5),
(237, 'Barra do Choça', 5),
(238, 'Barra do Mendes', 5),
(239, 'Barra do Rocha', 5),
(240, 'Barreiras', 5),
(241, 'Barro Alto', 5),
(242, 'Barrocas', 5),
(243, 'Barro Preto', 5),
(244, 'Belmonte', 5),
(245, 'Belo Campo', 5),
(246, 'Biritinga', 5),
(247, 'Boa Nova', 5),
(248, 'Boa Vista do Tupim', 5),
(249, 'Bom Jesus da Lapa', 5),
(250, 'Bom Jesus da Serra', 5),
(251, 'Boninal', 5),
(252, 'Bonito', 5),
(253, 'Boquira', 5),
(254, 'Botuporã', 5),
(255, 'Brejões', 5),
(256, 'Brejolândia', 5),
(257, 'Brotas de Macaúbas', 5),
(258, 'Brumado', 5),
(259, 'Buerarema', 5),
(260, 'Buritirama', 5),
(261, 'Caatiba', 5),
(262, 'Cabaceiras do Paraguaçu', 5),
(263, 'Cachoeira', 5),
(264, 'Caculé', 5),
(265, 'Caém', 5),
(266, 'Caetanos', 5),
(267, 'Caetité', 5),
(268, 'Cafarnaum', 5),
(269, 'Cairu', 5),
(270, 'Caldeirão Grande', 5),
(271, 'Camacan', 5),
(272, 'Camaçari', 5),
(273, 'Camamu', 5),
(274, 'Campo Alegre de Lourdes', 5),
(275, 'Campo Formoso', 5),
(276, 'Canápolis', 5),
(277, 'Canarana', 5),
(278, 'Canavieiras', 5),
(279, 'Candeal', 5),
(280, 'Candeias', 5),
(281, 'Candiba', 5),
(282, 'Cândido Sales', 5),
(283, 'Cansanção', 5),
(284, 'Canudos', 5),
(285, 'Capela do Alto Alegre', 5),
(286, 'Capim Grosso', 5),
(287, 'Caraíbas', 5),
(288, 'Caravelas', 5),
(289, 'Cardeal da Silva', 5),
(290, 'Carinhanha', 5),
(291, 'Casa Nova', 5),
(292, 'Castro Alves', 5),
(293, 'Catolândia', 5),
(294, 'Catu', 5),
(295, 'Caturama', 5),
(296, 'Central', 5),
(297, 'Chorrochó', 5),
(298, 'Cícero Dantas', 5),
(299, 'Cipó', 5),
(300, 'Coaraci', 5),
(301, 'Cocos', 5),
(302, 'Conceição da Feira', 5),
(303, 'Conceição do Almeida', 5),
(304, 'Conceição do Coité', 5),
(305, 'Conceição do Jacuípe', 5),
(306, 'Conde', 5),
(307, 'Condeúba', 5),
(308, 'Contendas do Sincorá', 5),
(309, 'Coração de Maria', 5),
(310, 'Cordeiros', 5),
(311, 'Coribe', 5),
(312, 'Coronel João Sá', 5),
(313, 'Correntina', 5),
(314, 'Cotegipe', 5),
(315, 'Cravolândia', 5),
(316, 'Crisópolis', 5),
(317, 'Cristópolis', 5),
(318, 'Cruz das Almas', 5),
(319, 'Curaçá', 5),
(320, 'Dário Meira', 5),
(321, 'Dias d Ávila', 5),
(322, 'Dom Basílio', 5),
(323, 'Dom Macedo Costa', 5),
(324, 'Elísio Medrado', 5),
(325, 'Encruzilhada', 5),
(326, 'Entre Rios', 5),
(327, 'Érico Cardoso', 5),
(328, 'Esplanada', 5),
(329, 'Euclides da Cunha', 5),
(330, 'Eunápolis', 5),
(331, 'Fátima', 5),
(332, 'Feira da Mata', 5),
(333, 'Feira de Santana', 5),
(334, 'Filadélfia', 5),
(335, 'Firmino Alves', 5),
(336, 'Floresta Azul', 5),
(337, 'Formosa do Rio Preto', 5),
(338, 'Gandu', 5),
(339, 'Gavião', 5),
(340, 'Gentio do Ouro', 5),
(341, 'Glória', 5),
(342, 'Gongogi', 5),
(343, 'Governador Mangabeira', 5),
(344, 'Guajeru', 5),
(345, 'Guanambi', 5),
(346, 'Guaratinga', 5),
(347, 'Heliópolis', 5),
(348, 'Iaçu', 5),
(349, 'Ibiassucê', 5),
(350, 'Ibicaraí', 5),
(351, 'Ibicoara', 5),
(352, 'Ibicuí', 5),
(353, 'Ibipeba', 5),
(354, 'Ibipitanga', 5),
(355, 'Ibiquera', 5),
(356, 'Ibirapitanga', 5),
(357, 'Ibirapuã', 5),
(358, 'Ibirataia', 5),
(359, 'Ibitiara', 5),
(360, 'Ibititá', 5),
(361, 'Ibotirama', 5),
(362, 'Ichu', 5),
(363, 'Igaporã', 5),
(364, 'Igrapiúna', 5),
(365, 'Iguaí', 5),
(366, 'Ilhéus', 5),
(367, 'Inhambupe', 5),
(368, 'Ipecaetá', 5),
(369, 'Ipiaú', 5),
(370, 'Ipirá', 5),
(371, 'Ipupiara', 5),
(372, 'Irajuba', 5),
(373, 'Iramaia', 5),
(374, 'Iraquara', 5),
(375, 'Irará', 5),
(376, 'Irecê', 5),
(377, 'Itabela', 5),
(378, 'Itaberaba', 5),
(379, 'Itabuna', 5),
(380, 'Itacaré', 5),
(381, 'Itaeté', 5),
(382, 'Itagi', 5),
(383, 'Itagibá', 5),
(384, 'Itagimirim', 5),
(385, 'Itaguaçu da Bahia', 5),
(386, 'Itaju do Colônia', 5),
(387, 'Itajuípe', 5),
(388, 'Itamaraju', 5),
(389, 'Itamari', 5),
(390, 'Itambé', 5),
(391, 'Itanagra', 5),
(392, 'Itanhém', 5),
(393, 'Itaparica', 5),
(394, 'Itapé', 5),
(395, 'Itapebi', 5),
(396, 'Itapetinga', 5),
(397, 'Itapicuru', 5),
(398, 'Itapitanga', 5),
(399, 'Itaquara', 5),
(400, 'Itarantim', 5),
(401, 'Itatim', 5),
(402, 'Itiruçu', 5),
(403, 'Itiúba', 5),
(404, 'Itororó', 5),
(405, 'Ituaçu', 5),
(406, 'Ituberá', 5),
(407, 'Iuiú', 5),
(408, 'Jaborandi', 5),
(409, 'Jacaraci', 5),
(410, 'Jacobina', 5),
(411, 'Jaguaquara', 5),
(412, 'Jaguarari', 5),
(413, 'Jaguaripe', 5),
(414, 'Jandaíra', 5),
(415, 'Jequié', 5),
(416, 'Jeremoabo', 5),
(417, 'Jiquiriçá', 5),
(418, 'Jitaúna', 5),
(419, 'João Dourado', 5),
(420, 'Juazeiro', 5),
(421, 'Jucuruçu', 5),
(422, 'Jussara', 5),
(423, 'Jussari', 5),
(424, 'Jussiape', 5),
(425, 'Lafaiete Coutinho', 5),
(426, 'Lagoa Real', 5),
(427, 'Laje', 5),
(428, 'Lajedão', 5),
(429, 'Lajedinho', 5),
(430, 'Lajedo do Tabocal', 5),
(431, 'Lamarão', 5),
(432, 'Lapão', 5),
(433, 'Lauro de Freitas', 5),
(434, 'Lençóis', 5),
(435, 'Licínio de Almeida', 5),
(436, 'Livramento de Nossa Senhora', 5),
(437, 'Luís Eduardo Magalhães', 5),
(438, 'Macajuba', 5),
(439, 'Macarani', 5),
(440, 'Macaúbas', 5),
(441, 'Macururé', 5),
(442, 'Madre de Deus', 5),
(443, 'Maetinga', 5),
(444, 'Maiquinique', 5),
(445, 'Mairi', 5),
(446, 'Malhada', 5),
(447, 'Malhada de Pedras', 5),
(448, 'Manoel Vitorino', 5),
(449, 'Mansidão', 5),
(450, 'Maracás', 5),
(451, 'Maragogipe', 5),
(452, 'Maraú', 5),
(453, 'Marcionílio Souza', 5),
(454, 'Mascote', 5),
(455, 'Mata de São João', 5),
(456, 'Matina', 5),
(457, 'Medeiros Neto', 5),
(458, 'Miguel Calmon', 5),
(459, 'Milagres', 5),
(460, 'Mirangaba', 5),
(461, 'Mirante', 5),
(462, 'Monte Santo', 5),
(463, 'Morpará', 5),
(464, 'Morro do Chapéu', 5),
(465, 'Mortugaba', 5),
(466, 'Mucugê', 5),
(467, 'Mucuri', 5),
(468, 'Mulungu do Morro', 5),
(469, 'Mundo Novo', 5),
(470, 'Muniz Ferreira', 5),
(471, 'Muquém de São Francisco', 5),
(472, 'Muritiba', 5),
(473, 'Mutuípe', 5),
(474, 'Nazaré', 5),
(475, 'Nilo Peçanha', 5),
(476, 'Nordestina', 5),
(477, 'Nova Canaã', 5),
(478, 'Nova Fátima', 5),
(479, 'Nova Ibiá', 5),
(480, 'Nova Itarana', 5),
(481, 'Nova Redenção', 5),
(482, 'Nova Soure', 5),
(483, 'Nova Viçosa', 5),
(484, 'Novo Horizonte', 5),
(485, 'Novo Triunfo', 5),
(486, 'Olindina', 5),
(487, 'Oliveira dos Brejinhos', 5),
(488, 'Ouriçangas', 5),
(489, 'Ourolândia', 5),
(490, 'Palmas de Monte Alto', 5),
(491, 'Palmeiras', 5),
(492, 'Paramirim', 5),
(493, 'Paratinga', 5),
(494, 'Paripiranga', 5),
(495, 'Pau Brasil', 5),
(496, 'Paulo Afonso', 5),
(497, 'Pé de Serra', 5),
(498, 'Pedrão', 5),
(499, 'Pedro Alexandre', 5),
(500, 'Piatã', 5),
(501, 'Pilão Arcado', 5),
(502, 'Pindaí', 5),
(503, 'Pindobaçu', 5),
(504, 'Pintadas', 5),
(505, 'Piraí do Norte', 5),
(506, 'Piripá', 5),
(507, 'Piritiba', 5),
(508, 'Planaltino', 5),
(509, 'Planalto', 5),
(510, 'Poções', 5),
(511, 'Pojuca', 5),
(512, 'Ponto Novo', 5),
(513, 'Porto Seguro', 5),
(514, 'Potiraguá', 5),
(515, 'Prado', 5),
(516, 'Presidente Dutra', 5),
(517, 'Presidente Jânio Quadros', 5),
(518, 'Presidente Tancredo Neves', 5),
(519, 'Queimadas', 5),
(520, 'Quijingue', 5),
(521, 'Quixabeira', 5),
(522, 'Rafael Jambeiro', 5),
(523, 'Remanso', 5),
(524, 'Retirolândia', 5),
(525, 'Riachão das Neves', 5),
(526, 'Riachão do Jacuípe', 5),
(527, 'Riacho de Santana', 5),
(528, 'Ribeira do Amparo', 5),
(529, 'Ribeira do Pombal', 5),
(530, 'Ribeirão do Largo', 5),
(531, 'Rio de Contas', 5),
(532, 'Rio do Antônio', 5),
(533, 'Rio do Pires', 5),
(534, 'Rio Real', 5),
(535, 'Rodelas', 5),
(536, 'Ruy Barbosa', 5),
(537, 'Salinas da Margarida', 5),
(538, 'Salvador', 5),
(539, 'Santa Bárbara', 5),
(540, 'Santa Brígida', 5),
(541, 'Santa Cruz Cabrália', 5),
(542, 'Santa Cruz da Vitória', 5),
(543, 'Santa Inês', 5),
(544, 'Santa Luzia', 5),
(545, 'Santa Maria da Vitória', 5),
(546, 'Santa Rita de Cássia', 5),
(547, 'Santa Teresinha', 5),
(548, 'Santaluz', 5),
(549, 'Santana', 5),
(550, 'Santanópolis', 5),
(551, 'Santo Amaro', 5),
(552, 'Santo Antônio de Jesus', 5),
(553, 'Santo Estêvão', 5),
(554, 'São Desidério', 5),
(555, 'São Domingos', 5),
(556, 'São Felipe', 5),
(557, 'São Félix', 5),
(558, 'São Félix do Coribe', 5),
(559, 'São Francisco do Conde', 5),
(560, 'São Gabriel', 5),
(561, 'São Gonçalo dos Campos', 5),
(562, 'São José da Vitória', 5),
(563, 'São José do Jacuípe', 5),
(564, 'São Miguel das Matas', 5),
(565, 'São Sebastião do Passé', 5),
(566, 'Sapeaçu', 5),
(567, 'Sátiro Dias', 5),
(568, 'Saubara', 5),
(569, 'Saúde', 5),
(570, 'Seabra', 5),
(571, 'Sebastião Laranjeiras', 5),
(572, 'Senhor do Bonfim', 5),
(573, 'Sento Sé', 5),
(574, 'Serra do Ramalho', 5),
(575, 'Serra Dourada', 5),
(576, 'Serra Preta', 5),
(577, 'Serrinha', 5),
(578, 'Serrolândia', 5),
(579, 'Simões Filho', 5),
(580, 'Sítio do Mato', 5),
(581, 'Sítio do Quinto', 5),
(582, 'Sobradinho', 5),
(583, 'Souto Soares', 5),
(584, 'Tabocas do Brejo Velho', 5),
(585, 'Tanhaçu', 5),
(586, 'Tanque Novo', 5),
(587, 'Tanquinho', 5),
(588, 'Taperoá', 5),
(589, 'Tapiramutá', 5),
(590, 'Teixeira de Freitas', 5),
(591, 'Teodoro Sampaio', 5),
(592, 'Teofilândia', 5),
(593, 'Teolândia', 5),
(594, 'Terra Nova', 5),
(595, 'Tremedal', 5),
(596, 'Tucano', 5),
(597, 'Uauá', 5),
(598, 'Ubaíra', 5),
(599, 'Ubaitaba', 5),
(600, 'Ubatã', 5),
(601, 'Uibaí', 5),
(602, 'Umburanas', 5),
(603, 'Una', 5),
(604, 'Urandi', 5),
(605, 'Uruçuca', 5),
(606, 'Utinga', 5),
(607, 'Valença', 5),
(608, 'Valente', 5),
(609, 'Várzea da Roça', 5),
(610, 'Várzea do Poço', 5),
(611, 'Várzea Nova', 5),
(612, 'Varzedo', 5),
(613, 'Vera Cruz', 5),
(614, 'Vereda', 5),
(615, 'Vitória da Conquista', 5),
(616, 'Wagner', 5),
(617, 'Wanderley', 5),
(618, 'Wenceslau Guimarães', 5),
(619, 'Xique-Xique', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `descricaopermissao`
--

CREATE TABLE `descricaopermissao` (
  `id_permissao` int(11) NOT NULL,
  `descricao` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `descricaopermissao`
--

INSERT INTO `descricaopermissao` (`id_permissao`, `descricao`) VALUES
(0, 'soldado'),
(2, 'p1'),
(3, 'p3'),
(4, 'p4'),
(5, 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estadocivil`
--

CREATE TABLE `estadocivil` (
  `id` int(1) NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `estadocivil`
--

INSERT INTO `estadocivil` (`id`, `estado`) VALUES
(1, 'Solteiro'),
(2, 'Casado'),
(3, 'Divorciado'),
(4, 'Viúvo'),
(5, 'Separado judicialmente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE `estados` (
  `id` int(2) NOT NULL,
  `nome` varchar(75) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `nome`, `uf`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amazonas', 'AM'),
(4, 'Amapá', 'AP'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Minas Gerais', 'MG'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Mato Grosso', 'MT'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Pernambuco', 'PE'),
(17, 'Piauí', 'PI'),
(18, 'Paraná', 'PR'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rondônia', 'RO'),
(22, 'Roraima', 'RR'),
(23, 'Rio Grande do Sul', 'RS'),
(24, 'Santa Catarina', 'SC'),
(25, 'Sergipe', 'SE'),
(26, 'São Paulo', 'SP'),
(27, 'Tocantins', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `graduacao`
--

CREATE TABLE `graduacao` (
  `id` int(2) NOT NULL,
  `posto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `graduacao`
--

INSERT INTO `graduacao` (`id`, `posto`) VALUES
(1, 'Sd PM 2ª Cl'),
(2, 'Sd PM'),
(3, 'Cb PM'),
(4, 'Al Sgt PM'),
(5, '3º Sgt PM'),
(6, '2º Sgt PM'),
(7, '1º Sgt PM'),
(8, 'Subten PM'),
(9, 'Al Of PM'),
(10, 'Asp Of PM'),
(11, '2º Ten PM'),
(12, '1º Ten PM'),
(13, 'Cap PM'),
(14, 'Maj PM'),
(15, 'Ten Cel PM'),
(16, 'Cel PM');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logradouro`
--

CREATE TABLE `logradouro` (
  `id` int(2) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `logradouro`
--

INSERT INTO `logradouro` (`id`, `tipo`) VALUES
(1, 'Rua'),
(2, 'Avenida'),
(3, 'Praça'),
(4, 'Alameda'),
(5, 'Travessa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `p1`
--

CREATE TABLE `p1` (
  `id` int(2) NOT NULL,
  `RE` varchar(8) NOT NULL,
  `NomeCompleto` varchar(55) NOT NULL,
  `NomeGuerra` varchar(50) NOT NULL,
  `DataNascimento` date NOT NULL,
  `DataAdmissao` date NOT NULL,
  `Id_TipoSanguineo` int(1) NOT NULL,
  `Id_CidadeNatal` int(5) NOT NULL,
  `Id_CidadeEndereco` int(5) NOT NULL,
  `NomePai` varchar(55) NOT NULL,
  `NomeMae` varchar(55) NOT NULL,
  `Id_EstadoCivil` int(1) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `RG` varchar(12) NOT NULL,
  `CNH` varchar(11) NOT NULL,
  `ValidadeCNH` date NOT NULL,
  `Id_CategoriaCNH` int(1) NOT NULL,
  `Id_SATCNH` int(1) NOT NULL,
  `CEP` varchar(9) NOT NULL,
  `Endereco` varchar(100) NOT NULL,
  `Numero` int(5) NOT NULL,
  `Id_Logradouro` int(2) NOT NULL,
  `Bairro` varchar(50) NOT NULL,
  `Complemento` varchar(100) DEFAULT NULL,
  `NomeConjuge` varchar(70) DEFAULT NULL,
  `DtNascConjuge` date DEFAULT NULL,
  `Id_Sexo` int(1) NOT NULL,
  `Telefone1` varchar(15) NOT NULL,
  `Telefone2` varchar(15) DEFAULT NULL,
  `TelefoneRecados` varchar(15) NOT NULL,
  `img` varchar(80) DEFAULT 'img/usuario.png',
  `Id_graduacao` int(2) NOT NULL,
  `Id_estadoAtual` int(2) NOT NULL,
  `Id_estadoNatal` int(2) NOT NULL,
  `DtApresentacao` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `p1`
--

INSERT INTO `p1` (`id`, `RE`, `NomeCompleto`, `NomeGuerra`, `DataNascimento`, `DataAdmissao`, `Id_TipoSanguineo`, `Id_CidadeNatal`, `Id_CidadeEndereco`, `NomePai`, `NomeMae`, `Id_EstadoCivil`, `CPF`, `RG`, `CNH`, `ValidadeCNH`, `Id_CategoriaCNH`, `Id_SATCNH`, `CEP`, `Endereco`, `Numero`, `Id_Logradouro`, `Bairro`, `Complemento`, `NomeConjuge`, `DtNascConjuge`, `Id_Sexo`, `Telefone1`, `Telefone2`, `TelefoneRecados`, `img`, `Id_graduacao`, `Id_estadoAtual`, `Id_estadoNatal`, `DtApresentacao`, `status`) VALUES
(1, '160788-0', 'Renan Ramalho Silva', 'Ramalho', '2024-11-10', '2024-11-10', 7, 1, 1, 'gnvnv', 'gcnfcnfcnfcn', 3, '407.686.498-03', '77.767.677-5', '65765767756', '2024-11-10', 6, 6, '65646-465', 'fgdhfdhfd', 554, 1, 'fdffddh', 'fbxbfx', '', '0000-00-00', 1, '(54) 65546-6464', '', '', NULL, 2, 1, 1, '2024-11-10', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `p1cursos`
--

CREATE TABLE `p1cursos` (
  `id_curso` int(3) NOT NULL,
  `id_p1` int(6) NOT NULL,
  `NomeCurso` varchar(100) NOT NULL,
  `DtInicio` date NOT NULL,
  `DtTermino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `p1cursos`
--

INSERT INTO `p1cursos` (`id_curso`, `id_p1`, `NomeCurso`, `DtInicio`, `DtTermino`) VALUES
(1, 1, 'Python Avancado', '2024-11-10', '2024-11-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `p1filhos`
--

CREATE TABLE `p1filhos` (
  `id_filho` int(3) NOT NULL,
  `id_p1` int(6) DEFAULT NULL,
  `NomeFilho` varchar(55) DEFAULT NULL,
  `DtNascimento` date DEFAULT NULL,
  `Id_Sexo` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `id_permissao` int(11) NOT NULL,
  `id_pm` int(11) NOT NULL,
  `permissao` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id_permissao`, `id_pm`, `permissao`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sexo`
--

CREATE TABLE `sexo` (
  `id` int(1) NOT NULL,
  `Descricao` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `sexo`
--

INSERT INTO `sexo` (`id`, `Descricao`) VALUES
(1, 'Masculino'),
(2, 'Feminino'),
(3, 'Prefiro nao informar'),
(4, 'outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposanguineo`
--

CREATE TABLE `tiposanguineo` (
  `id` int(1) NOT NULL,
  `tipo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tiposanguineo`
--

INSERT INTO `tiposanguineo` (`id`, `tipo`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoriacnh`
--
ALTER TABLE `categoriacnh`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cidades_estados` (`id_estado`);

--
-- Índices para tabela `descricaopermissao`
--
ALTER TABLE `descricaopermissao`
  ADD PRIMARY KEY (`id_permissao`);

--
-- Índices para tabela `estadocivil`
--
ALTER TABLE `estadocivil`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `graduacao`
--
ALTER TABLE `graduacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logradouro`
--
ALTER TABLE `logradouro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `p1`
--
ALTER TABLE `p1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RE` (`RE`),
  ADD KEY `fk_p1_cidadenatal` (`Id_CidadeNatal`),
  ADD KEY `fk_p1_cidadeendereco` (`Id_CidadeEndereco`),
  ADD KEY `fk_p1_logradouro` (`Id_Logradouro`),
  ADD KEY `fk_p1_categoriaCNH` (`Id_CategoriaCNH`),
  ADD KEY `fk_p1_estadocivil` (`Id_EstadoCivil`),
  ADD KEY `fk_p1_tiposanguineo` (`Id_TipoSanguineo`),
  ADD KEY `fk_p1_satcnh` (`Id_SATCNH`),
  ADD KEY `fk_p1_sexo` (`Id_Sexo`),
  ADD KEY `Id_graduacao` (`Id_graduacao`),
  ADD KEY `Id_estadoNatal` (`Id_estadoNatal`),
  ADD KEY `Id_estadoAtual` (`Id_estadoAtual`);

--
-- Índices para tabela `p1cursos`
--
ALTER TABLE `p1cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `fk_curso_p1` (`id_p1`);

--
-- Índices para tabela `p1filhos`
--
ALTER TABLE `p1filhos`
  ADD PRIMARY KEY (`id_filho`),
  ADD KEY `fk_filho_p1` (`id_p1`),
  ADD KEY `fk_filho_sexo` (`Id_Sexo`);

--
-- Índices para tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id_permissao`),
  ADD KEY `permissao` (`permissao`),
  ADD KEY `id_pm` (`id_pm`);

--
-- Índices para tabela `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tiposanguineo`
--
ALTER TABLE `tiposanguineo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoriacnh`
--
ALTER TABLE `categoriacnh`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=620;

--
-- AUTO_INCREMENT de tabela `descricaopermissao`
--
ALTER TABLE `descricaopermissao`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `estadocivil`
--
ALTER TABLE `estadocivil`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `graduacao`
--
ALTER TABLE `graduacao`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `logradouro`
--
ALTER TABLE `logradouro`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `p1`
--
ALTER TABLE `p1`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `p1cursos`
--
ALTER TABLE `p1cursos`
  MODIFY `id_curso` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `p1filhos`
--
ALTER TABLE `p1filhos`
  MODIFY `id_filho` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tiposanguineo`
--
ALTER TABLE `tiposanguineo`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cidades`
--
ALTER TABLE `cidades`
  ADD CONSTRAINT `fk_cidades_estados` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id`);

--
-- Limitadores para a tabela `p1`
--
ALTER TABLE `p1`
  ADD CONSTRAINT `fk_p1_categoriaCNH` FOREIGN KEY (`Id_CategoriaCNH`) REFERENCES `categoriacnh` (`id`),
  ADD CONSTRAINT `fk_p1_cidadeendereco` FOREIGN KEY (`Id_CidadeEndereco`) REFERENCES `cidades` (`id`),
  ADD CONSTRAINT `fk_p1_cidadenatal` FOREIGN KEY (`Id_CidadeNatal`) REFERENCES `cidades` (`id`),
  ADD CONSTRAINT `fk_p1_estadocivil` FOREIGN KEY (`Id_EstadoCivil`) REFERENCES `estadocivil` (`id`),
  ADD CONSTRAINT `fk_p1_logradouro` FOREIGN KEY (`Id_Logradouro`) REFERENCES `logradouro` (`id`),
  ADD CONSTRAINT `fk_p1_satcnh` FOREIGN KEY (`Id_SATCNH`) REFERENCES `categoriacnh` (`id`),
  ADD CONSTRAINT `fk_p1_sexo` FOREIGN KEY (`Id_Sexo`) REFERENCES `sexo` (`id`),
  ADD CONSTRAINT `fk_p1_tiposanguineo` FOREIGN KEY (`Id_TipoSanguineo`) REFERENCES `tiposanguineo` (`id`),
  ADD CONSTRAINT `p1_ibfk_1` FOREIGN KEY (`Id_graduacao`) REFERENCES `graduacao` (`id`),
  ADD CONSTRAINT `p1_ibfk_2` FOREIGN KEY (`Id_estadoNatal`) REFERENCES `estados` (`id`),
  ADD CONSTRAINT `p1_ibfk_3` FOREIGN KEY (`Id_estadoAtual`) REFERENCES `estados` (`id`);

--
-- Limitadores para a tabela `p1cursos`
--
ALTER TABLE `p1cursos`
  ADD CONSTRAINT `fk_curso_p1` FOREIGN KEY (`id_p1`) REFERENCES `p1` (`id`);

--
-- Limitadores para a tabela `p1filhos`
--
ALTER TABLE `p1filhos`
  ADD CONSTRAINT `fk_filho_p1` FOREIGN KEY (`id_p1`) REFERENCES `p1` (`id`),
  ADD CONSTRAINT `fk_filho_sexo` FOREIGN KEY (`Id_Sexo`) REFERENCES `sexo` (`id`);

--
-- Limitadores para a tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD CONSTRAINT `permissoes_ibfk_1` FOREIGN KEY (`permissao`) REFERENCES `descricaopermissao` (`id_permissao`),
  ADD CONSTRAINT `permissoes_ibfk_2` FOREIGN KEY (`id_pm`) REFERENCES `p1` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
