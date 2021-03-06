-- phpMyAdmin SQL Dump
-- version 2.11.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 13 Giu, 2013 at 07:23 PM
-- Versione MySQL: 5.5.15
-- Versione PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `my_tumorsdatabase`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `chemioterapia`
--

CREATE TABLE IF NOT EXISTS `chemioterapia` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `temozolomide` varchar(10) DEFAULT NULL,
  `data_temozolomide` date DEFAULT NULL,
  `cicli_temozolomide` int(5) DEFAULT NULL,
  `pc_v` varchar(10) DEFAULT NULL,
  `data_pc_v` date DEFAULT NULL,
  `cicli_pc_v` int(5) DEFAULT NULL,
  `fotemustina` varchar(10) DEFAULT NULL,
  `data_fotemustina` date DEFAULT NULL,
  `cicli_fotemustina` int(5) DEFAULT NULL,
  `altro` varchar(500) DEFAULT NULL,
  `data_altro` date DEFAULT NULL,
  `terapia_supporto` varchar(500) DEFAULT NULL,
  `data_terapia_supporto` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `chemioterapia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `esame_tc`
--

CREATE TABLE IF NOT EXISTS `esame_tc` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(11) NOT NULL,
  `extrassiale` varchar(10) DEFAULT NULL,
  `intrassiale` varchar(10) DEFAULT NULL,
  `dubbia` varchar(10) DEFAULT NULL,
  `contrasto` varchar(10) DEFAULT NULL,
  `tipo_contrasto` varchar(50) DEFAULT NULL,
  `sede` varchar(200) DEFAULT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `esame_tc`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `nome_file` varchar(600) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `files`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `inserimento`
--

CREATE TABLE IF NOT EXISTS `inserimento` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(10) NOT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `inserimento`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `intervento`
--

CREATE TABLE IF NOT EXISTS `intervento` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(10) NOT NULL,
  `data_inserimento` date NOT NULL,
  `biopsia` varchar(30) DEFAULT NULL,
  `data_biopsia` date NOT NULL,
  `resezione_totale` varchar(30) DEFAULT NULL,
  `data_resezione_totale` date NOT NULL,
  `resezione_parziale` varchar(30) DEFAULT NULL,
  `data_resezione_parziale` date NOT NULL,
  `resezione_gliadel` varchar(30) DEFAULT NULL,
  `data_resezione_gliadel` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `intervento`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `istologia`
--

CREATE TABLE IF NOT EXISTS `istologia` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `data_risultato` date NOT NULL,
  `nome_tumore` varchar(500) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `istologia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `surname` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_birthday` date NOT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `telephone` varchar(500) DEFAULT NULL,
  `note` longtext,
  `reparto_provenienza` varchar(300) DEFAULT NULL,
  `data_decesso` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `patient`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `permeabilita`
--

CREATE TABLE IF NOT EXISTS `permeabilita` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `data_inserimento` date NOT NULL,
  `k_trans` double NOT NULL,
  `vi` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `permeabilita`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `rm_bold`
--

CREATE TABLE IF NOT EXISTS `rm_bold` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `data_inserimento` date NOT NULL,
  `motorio_sede` varchar(100) DEFAULT NULL,
  `motorio_anteriore` varchar(10) DEFAULT NULL,
  `motorio_posteriore` varchar(10) DEFAULT NULL,
  `motorio_mediale` varchar(10) DEFAULT NULL,
  `motorio_intralesionale` varchar(10) DEFAULT NULL,
  `motorio_laterale` varchar(10) DEFAULT NULL,
  `motorio_inferiore` varchar(10) DEFAULT NULL,
  `motorio_superiore` varchar(10) DEFAULT NULL,
  `motorio_altro` varchar(300) DEFAULT NULL,
  `sensitiva_sede` varchar(200) DEFAULT NULL,
  `sensitiva_anteriore` varchar(10) DEFAULT NULL,
  `sensitiva_posteriore` varchar(10) DEFAULT NULL,
  `sensitiva_mediale` varchar(10) DEFAULT NULL,
  `sensitiva_intralesionale` varchar(10) DEFAULT NULL,
  `sensitiva_laterale` varchar(10) DEFAULT NULL,
  `sensitiva_inferiore` varchar(10) DEFAULT NULL,
  `sensitiva_superiore` varchar(10) DEFAULT NULL,
  `sensitiva_altro` varchar(300) DEFAULT NULL,
  `linguaggio_broca` varchar(10) DEFAULT NULL,
  `linguaggio_wernicke` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `rm_bold`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `rm_dti`
--

CREATE TABLE IF NOT EXISTS `rm_dti` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `data_inserimento` date NOT NULL,
  `valore_fa` double DEFAULT NULL,
  `cortico_spinale` varchar(100) DEFAULT NULL,
  `arcuato` varchar(100) DEFAULT NULL,
  `longitudinale_inferiore` varchar(100) DEFAULT NULL,
  `vie_ottiche` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `rm_dti`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `rm_morfologica`
--

CREATE TABLE IF NOT EXISTS `rm_morfologica` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `extrassiale` varchar(10) DEFAULT NULL,
  `intrassiale` varchar(10) DEFAULT NULL,
  `t2_flair` varchar(10) DEFAULT NULL,
  `flair_3d` varchar(10) DEFAULT NULL,
  `volume_neo` double DEFAULT NULL,
  `dwi` varchar(10) DEFAULT NULL,
  `dwi_ristretta` varchar(10) DEFAULT NULL,
  `adc` varchar(10) DEFAULT NULL,
  `tipo_adc` varchar(70) DEFAULT NULL,
  `valore_adc` double DEFAULT NULL,
  `ce` varchar(10) DEFAULT NULL,
  `tipo_ce` varchar(100) DEFAULT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `rm_morfologica`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `rm_perfusione`
--

CREATE TABLE IF NOT EXISTS `rm_perfusione` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `r_cbv` varchar(40) DEFAULT NULL,
  `valore_r_cbv` double DEFAULT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `rm_perfusione`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `rm_spettroscopica`
--

CREATE TABLE IF NOT EXISTS `rm_spettroscopica` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(9) NOT NULL,
  `naa_ridotto` varchar(10) DEFAULT NULL,
  `valore_naa_cr` double DEFAULT NULL,
  `cho_cr` double DEFAULT NULL,
  `lipidi_lattati` varchar(10) DEFAULT NULL,
  `mioinositolo` varchar(10) DEFAULT NULL,
  `tipo_spettro` varchar(30) DEFAULT NULL,
  `te` varchar(100) NOT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `rm_spettroscopica`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `sede`
--

CREATE TABLE IF NOT EXISTS `sede` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `sede` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `sede`
--

INSERT INTO `sede` (`id`, `sede`) VALUES
(1, 'Cervelletto'),
(2, 'Tronco Encefalico'),
(3, 'Regione Sellare'),
(4, 'Occipitale'),
(5, 'Temporale'),
(6, 'Parietale'),
(7, 'Frontale'),
(8, 'Nuclei della base');

-- --------------------------------------------------------

--
-- Struttura della tabella `sintomi`
--

CREATE TABLE IF NOT EXISTS `sintomi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(10) NOT NULL,
  `data_sintomi` varchar(100) NOT NULL,
  `deficit` varchar(10) DEFAULT NULL,
  `crisi_epilettica` varchar(10) DEFAULT NULL,
  `note` longtext,
  `disturbi_comportamento` varchar(10) DEFAULT NULL,
  `cefalea` varchar(10) DEFAULT NULL,
  `altro` varchar(500) DEFAULT NULL,
  `deficit_motorio` varchar(10) DEFAULT NULL,
  `data_inserimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `sintomi`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `terapia`
--

CREATE TABLE IF NOT EXISTS `terapia` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_paziente` int(8) NOT NULL,
  `rt_conformazionale` varchar(10) NOT NULL,
  `data_rt_conformazionale` date NOT NULL,
  `radiochirurgia` varchar(10) NOT NULL,
  `data_radiochirurgia` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `terapia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `try_date`
--

CREATE TABLE IF NOT EXISTS `try_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `try_date`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `tumors`
--

CREATE TABLE IF NOT EXISTS `tumors` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `main` varchar(600) NOT NULL,
  `name_1` varchar(600) NOT NULL,
  `name_2` varchar(600) NOT NULL,
  `definition` text NOT NULL,
  `link` varchar(500) NOT NULL,
  `icd_o_code` varchar(200) NOT NULL,
  `grade` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

--
-- Dump dei dati per la tabella `tumors`
--

INSERT INTO `tumors` (`id`, `main`, `name_1`, `name_2`, `definition`, `link`, `icd_o_code`, `grade`) VALUES
(1, 'Atrocytic tumors', 'Pilocytic astrocitoma', 'Pilocytic astrocitoma', 'Pilocytic astrocytomaorjuvenile pilocytic astrocytomaorcystic cerebellar astrocytoma(and its variant juvenile pilomyxoid astrocytoma) is aneoplasmof thebrainthat occurs more often in children and young adults (in the first 20 years of life). They usually arise in thecerebellum, near thebrainstem,hypothalamic region, or theoptic chiasm, but they may occur in any area whereastrocytesare present, including thecerebral hemispheresand thespinal cord. These tumors are usually slow growing. The neoplasms are associated with the formation of a single (or multiple)cyst(s), and can become very large. The pilocytic astrocytoma is, in general, considered abenigntumor. It is oftencystic, and, if solid, it tends to be well-circumscribed. It is characteristically a contrast-enhancing tumor by current imaging investigations (e.g.,CT scan,MRI). Juvenile pilocytic astrocytoma is associated withneurofibromatosistype 1 (NF1), andoptic gliomasare among the most frequently encountered tumors in patients with this disorder. It is classified asGrade 1Astrocytoma', 'http://en.wikipedia.org/wiki/Pilocytic_astrocytoma', '9421-1', '1'),
(2, 'Atrocytic tumors', 'Pleomorphic xanthoastrocytoma', 'Pleomorphic xanthoastrocytoma', 'Pleomorphic Xanthoastrocytoma is a neoplasm of the brain that occurs often in children and teenagers. They usually arise supratentorial and superficially from the cerebral hemispheres (upper most sections) of the brain and in contact with the leptomeninges, rarely they arise from the spinal cord. They are formed through the mitosis of astrocytes. The neoplasms are found in the area of the temples, frontal or on top of the parietal lobe, in about 20percent of cases more than one lobe was involved .\nThese tumors are usually slow growing, the neoplasms are associated with the sudden onset of seizures. Histologically, they can be associated with inflammatory cell infiltration and reticulin deposits. Very rarely, these tumors undergo transformation to a more malignant tumor. Pleomorphi Xanthoastrocytoma is, in general, considered a benign tumor. It will show up as a contrast-enhancing tumor by current imaging investigations (e.g., CT scan, MRI). It is classified as Grade II Astrocytoma. ', 'http://en.wikipedia.org/wiki/Pleomorphic_xanthoastrocytoma', '9424-3', '2'),
(3, 'Atrocytic tumors', 'Diffuse astrocytoma', 'Diffuse astrocytoma', ' ', '', '9400-3', '2'),
(4, 'Atrocytic tumors', 'Diffuse astrocytoma', 'Fibrillary astrocytoma', 'Fibrillary astrocytomasalso calledlow gradeordiffuseastrocytomas, are a group ofprimaryslow growingbrain tumors. They typically occur in adults between the ages of twenty and fifty', 'http://en.wikipedia.org/wiki/Fibrillary_astrocytoma', '9420-3', '2'),
(5, 'Atrocytic tumors', 'Diffuse astrocytoma', 'Gemistocytic astrocytoma', 'Gemistocytes are also found in somechronic diseasesand within certain brain tumors, which suggests the presence of a long-lasting pathological reaction. In the context ofcancer(gemistocytic astrocytomas), gemistocytes are known to dedifferentiate to a high grade (III or IV)glioma(i.e.glioblastoma multiforme) at a rapid pace, usually indicative of a poorprognosis.', 'http://en.wikipedia.org/wiki/Gemistocyte', '9411-3', '2'),
(6, 'Atrocytic tumors', 'Diffuse astrocytoma', 'Protoplasmic astrocytoma', '', '', '9410-3', '2'),
(7, 'Atrocytic tumors', 'Anaplastic astrocytoma', 'Anaplastic astrocytoma', 'Anaplastic astrocytoma is a WHO grade 3 type of astrocytoma. Initial presenting symptoms most commonly are headache, depressed mental status, focal neurological deficits, and/or seizures. The growth rate and mean interval between onset of symptoms and diagnosis is approximately 1.5?2 years but is highly variable,[1] being intermediate between that of low-grade astrocytomas and glioblastomas.[1] Seizures are less common among patients with anaplastic astrocytomas compared to low-grade lesions', 'http://en.wikipedia.org/wiki/Anaplastic_astrocytoma', '9401-3', '3'),
(8, 'Atrocytic tumors', 'Glioblastoma', 'Glioblastoma', 'Glioblastoma multiforme (GBM) is the most common and most aggressive malignant primary brain tumor in humans, involving glial cells and accounting for 52percent of all functional tissue brain tumor cases and 20percent of all intracranial tumors. Despite being the most prevalent form of primary brain tumor, GBMs occur in only 2?3 cases per 100,000 people in Europe and North America. According to the WHO classification of the tumors of the central nervous system?, the standard name for this brain tumor is glioblastoma; it presents two variants: giant cell glioblastoma and gliosarcoma. Glioblastomas are also an important brain tumor in canines, and research continues to use this as a model for developing treatments in humans. Treatment can involve chemotherapy, radiation, radiosurgery, corticosteroids, antiangiogenic therapy, surgery[2] and experimental approaches such as gene transfer.[3] With the exception of the brainstem gliomas, glioblastoma has the worst prognosis of any central nervous system (CNS) malignancy, despite multimodality treatment consisting of open craniotomy with surgical resection of as much of the tumor as possible, followed by concurrent or sequential chemoradiotherapy, antiangiogenic therapy with bevacizumab, gamma knife radiosurgery, and symptomatic management with corticosteroids. Prognosis is poor, with a median survival time of approximately 14 months.[4]', 'http://en.wikipedia.org/wiki/Glioblastoma', '9440-3', '4'),
(9, 'Atrocytic tumors', 'Glioblastoma', 'Giant cell glioblastoma', 'Thegiant-cell glioblastomais a histological variant ofglioblastoma, presenting a prevalence of bizarre, multinucleated (more than 20 nuclei) giant (up to 400 ?m diameter) cells', 'http://en.wikipedia.org/wiki/Giant_cell_glioblastoma', '9441-3', '4'),
(10, 'Atrocytic tumors', 'Glioblastoma', 'Gliosarcoma', 'Gliosarcomais a rare type ofglioma, acancerof the brain that comes fromglial, or supportive, brain cells, as opposed to theneuralbrain cells. Gliosarcoma is a malignant cancer, and is defined as a glioblastoma consisting of gliomatous andsarcomatouscomponents', 'http://en.wikipedia.org/wiki/Gliosarcoma', '9442-3', '4'),
(11, 'Atrocytic tumors', 'Glioblastoma', 'Gliofibroma', '', '', '', '4'),
(12, 'Atrocytic tumors', 'Gliomatosis cerebri', 'Gliomatosis cerebri', 'Gliomatosis cerebri (infiltrative diffuse astrocytosis)is a rare primarybrain tumor. It is commonly characterized by diffuse infiltration of the brain with neoplasticglial cellsthat affect various areas of the cerebral lobes.Glimatosis Cerebi behaves like a malignant tumor that is very similar to Glioblastoma.', 'http://en.wikipedia.org/wiki/Gliomatosis_cerebri', '9381-3', '3'),
(13, 'Oligodendroglial tumors', 'Oligodendroglioma', 'Oligodendroglioma', 'Oligodendrogliomasare a type ofgliomathat are believed to originate from theoligodendrocytesof thebrainor from a glial precursor cell. They occur primarily in adults (9.4percent of all primary brain and central nervous system tumors) but are also found in children (4percent of all primary brain tumors). The average age at diagnosis is 35 years.', 'http://en.wikipedia.org/wiki/Oligodendroglioma', '9450-3', '2'),
(14, 'Oligodendroglial tumors', 'Anaplastic Oligodendroglioma', 'Anaplastic Oligodendroglioma', '', '', '9451-3', '3'),
(15, 'Oligodendroglial tumors', 'Oligoastrocytoma', 'Oligoastrocytoma', 'Oligoastrocytomas are a subset of brain tumors that present with an appearance of mixed glial cell origin, astrocytoma and oligodendroglioma. These types of glial cells that become cancerous are involved with insulating and regulating the activity of neuron cells in the central nervous system. Often called a mixed glioma, about 2.3percent of all reported brain tumors are diagnosed as oligoastrocytoma.] The median age of diagnosis is 42 years of age. Oligoastrocytomas, like astrocytomas and oligodendrogliomas, can be divided into low-grade and anaplastic variant, the latter characterized by high cellularity, conspicuous cytologic atypism, mitotic activity and, in some cases, microvascular proliferation and necrosis.', 'http://en.wikipedia.org/wiki/Oligoastrocytoma', '9382-3', '2'),
(16, 'Oligodendroglial tumors', 'Anaplastic Oligoastrocytoma', 'Anaplastic Oligoastrocytoma', '', '', '9382-3', '3'),
(17, 'Ependymal tumors', 'Subependymoma', 'Subependymoma', 'Asubependymomais a type ofbrain tumor; specifically, it is a rare form ofependymal tumor', 'http://en.wikipedia.org/wiki/Subependymoma', '9383-1', '1'),
(18, 'Ependymal tumors', 'Myxopapillary ependymoma', 'Myxopapillary ependymoma', '', '', '9394-1', '1'),
(19, 'Ependymal tumors', 'Ependymoma', 'Ependymoma', 'Ependymomais atumorthat arises from theependyma, a tissue of thecentral nervous system. Usually, inpediatric casesthe location isintracranial, while in adults it isspinal. The common location of intracranial ependymoma is thefourth ventricle. Rarely, ependymoma can occur in thepelvic cavity.', 'http://en.wikipedia.org/wiki/Myxopapillary_ependymoma', '9391-3', '2'),
(20, 'Ependymal tumors', 'Ependymoma', 'Cellular ependymoma', '', '', '9391-3', '2'),
(21, 'Ependymal tumors', 'Ependymoma', 'Papillary ependymoma', '', '', '9393-3', '2'),
(22, 'Ependymal tumors', 'Ependymoma', 'Clear cell ependymoma', '', '', '9391-3', '2'),
(23, 'Ependymal tumors', 'Ependymoma', 'Tanycytic ependymoma', '', '', '9391-3', '2'),
(24, 'Ependymal tumors', 'Anaplastic ependymoma', 'Anaplastic ependymoma', '', '', '9392-3', '3'),
(25, 'Choroid Plexus Tumors', 'Choroid Plexus Tumors', 'Choroid plexus papilloma', 'AChoroid plexus papilloma(CPP) is a rare, slow-growing, histologically benign intracranialneoplasmortumorthat is commonly located in theventricular systemof thechoroid plexus. It may obstruct thecerebrospinal fluidflow, causing increasedintracranial pressure', 'http://en.wikipedia.org/wiki/Choroid_plexus_papilloma', '9390-0', '1'),
(26, 'Choroid Plexus Tumors', 'Choroid Plexus Tumors', 'Atypical choroid plexus papilloma', '', '', '9390-1', '1'),
(27, 'Choroid Plexus Tumors', 'Choroid Plexus Tumors', 'Choroid plexus carcinoma', 'Achoroid plexus carcinomais a type ofchoroid plexus tumor', 'http://en.wikipedia.org/wiki/Choroid_plexus_carcinoma', '9390-3', '2'),
(28, 'Other Neuroepithelial tumors', 'Astroblastoma', 'Astroblastoma', 'Astroblastomais a rare glialtumorderived from the astroblast, a type of cell that closely resemblesspongioblastomaandastrocytes.Astroblastoma cells are most likely found in the supratentorial region of the brain that houses thecerebrum, an area responsible for all voluntary movements in the body.It also occurs significantly in thefrontal lobe,parietal lobe, andtemporal lobe, areas where movement, language creation, memory perception, and environmental surroundings are expressed. These tumors can be present in major brain areas not associated with the main cerebral hemispheres, including thecerebellum,optic nerve,cauda equina,hypothalamus, andbrain stem', 'http://en.wikipedia.org/wiki/Astroblastoma', '9430-3', 'var'),
(29, 'Other Neuroepithelial tumors', 'Chordoid glioma of the third ventricle', 'Chordoid glioma of the third ventricle', '', '', '9444-1', '2'),
(30, 'Other Neuroepithelial tumors', 'Angiocentric glioma', 'Angiocentric glioma', '', '', '9431-1', '1'),
(31, 'Neuronal and Mixed neuronal-Glial Tumors', 'Desmoplastic infantile astrocytoma and ganglioglioma', 'Desmoplastic infantile astrocytoma and ganglioglioma', '', '', '9412-1', '1'),
(32, 'Neuronal and Mixed neuronal-Glial Tumors', 'Dysembryoplastic neuroepithelial tumour', 'Dysembryoplastic neuroepithelial tumour', 'Dysembryoplastic neuroepithelial tumour, commonly abbreviatedDNTorDNET, is a type ofbrain tumour. It appears similar tooligodendroglioma, but with visible neurons.', 'http://en.wikipedia.org/wiki/Dysembryoplastic_neuroepithelial_tumor', '9413-0', '1'),
(33, 'Neuronal and Mixed neuronal-Glial Tumors', 'Ganglioglioma and gangliocytoma', 'Gangliocytoma', 'Gangliogliomais a tumour that arises fromganglion cellsin thecentral nervous system', 'http://en.wikipedia.org/wiki/Gangliocytoma', '9492-02', '1'),
(34, 'Neuronal and Mixed neuronal-Glial Tumors', 'Ganglioglioma and gangliocytoma', 'Ganglioglioma', 'Gangliogliomais a tumour that arises fromganglion cellsin thecentral nervous system', 'http://en.wikipedia.org/wiki/Gangliocytoma', '9505-1', '1'),
(35, 'Neuronal and Mixed neuronal-Glial Tumors', 'Ganglioglioma and gangliocytoma', 'Anaplastic ganglioglioma', '', '', '9505-3', '3'),
(36, 'Neuronal and Mixed neuronal-Glial Tumors', 'Central neurocytoma and extraventricular neurocytoma', 'Central neurocytoma and extraventricular neurocytoma', '', '', '9506-1', '2'),
(37, 'Neuronal and Mixed neuronal-Glial Tumors', 'Cerebellar liponeurocytoma', 'Cerebellar liponeurocytoma', '', '', '9506-1', '1'),
(38, 'Neuronal and Mixed neuronal-Glial Tumors', 'Papillary glioneuronal tumor', 'Papillary glioneuronal tumor', '', '', '9509-1', '1'),
(39, 'Neuronal and Mixed neuronal-Glial Tumors', 'Rosette-forming glioneuronal tumor of the fourth ventricle', 'Rosette-forming glioneuronal tumor of the fourth ventricle', '', '', '9509-1', '1'),
(40, 'Neuronal and Mixed neuronal-Glial Tumors', 'Spinal paraganglioma', 'Spinal paraganglioma', 'Aparagangliomais a rareneuroendocrineneoplasmthat may develop at various body sites (including the head, neck, thorax and abdomen). About 97percent are benign and cured by surgical removal; the remaining 3percent are malignant because they are able to produce distantmetastases. Paragangliomas are still sometimes referred to using older, obsolete terminology (for example as chemodectomas or glomus jugularis, the latter not to be confused withglomus tumorsof the skin).', 'http://en.wikipedia.org/wiki/Paraganglioma', '8680-1', '1'),
(41, 'Tumors pf the Pineal Region', 'Pineocytoma', 'Pineocytoma', 'Pineocytoma, also known as a pinealocytoma, is a benign, slowly-growingtumorof thepineal gland. Unlike the similar conditionpineal gland cyst, it is uncommon', 'http://en.wikipedia.org/wiki/Pineocytoma', '9361-1', '1'),
(42, 'Tumors pf the Pineal Region', 'Pineal parenchymal tumor of intermediate differentiation', 'Pineal parenchymal tumor of intermediate differentiation', '', '', '9362-3', '2-3'),
(43, 'Tumors pf the Pineal Region', 'Pineoblastoma', 'Pineoblastoma', 'Pinealoblastomais atumorof thepineal gland. Retinoblastomacan be characterized as bilateral when it presents on both sides. It can also be characterized as trilateral when it presents with pinealoblastoma', 'http://en.wikipedia.org/wiki/Pinealoblastoma', '9362-3', '4'),
(44, 'Tumors pf the Pineal Region', 'Papillary tumors of the pineal region', 'Papillary tumors of the pineal region', 'Papillary tumors of the pineal region(PTPR) were first described by A. Jouvet et al. in 2003and were introduced in the World Health Organization (WHO) classification of Central Nervous System (CNS) in 2007.Papillary Tumors of the Pineal Region are located on thepineal glandwhich is located in the center of the brain. The pineal gland is located on roof of thediencephalon. It is a cone shaped structure dorsal to themidbrain tectum.The tumor appears to be derived from the specialized ependymal cells of thesubcommissural organ.Papillary tumors of thecentral nervous systemand particularly of the pineal region are very rare and so diagnosing them is extremely difficult.', 'http://en.wikipedia.org/wiki/Papillary_tumors_of_the_pineal_region', '9395-3', '2-3'),
(45, 'Embryonal Tumors', 'Medulloblastoma', 'Medulloblastoma', 'Medulloblastomais a highlymalignantprimarybrain tumorthat originates in thecerebellumorposterior fossa. Previously, medulloblastomas were thought to represent a subset of primitive neuroectodermal tumor (PNET) of the posterior fossa. However, gene expression profiling has shown that medulloblastomas have a distinct molecular profile and are distinct from other PNET tumors.', 'http://en.wikipedia.org/wiki/Medulloblastoma', '9470-3', '4'),
(46, 'Embryonal Tumors', 'Medulloblastoma', 'Desmoplastic/nodular Medulloblastoma', '', '', '9471-3', '4'),
(47, 'Embryonal Tumors', 'Medulloblastoma', 'Medulloblastoma with extensive nodularity', '', '', '9471-3', '4'),
(48, 'Embryonal Tumors', 'Medulloblastoma', 'Anaplastic Medulloblastoma', '', '', '9474-3', '4'),
(49, 'Embryonal Tumors', 'Medulloblastoma', 'Large cell Medulloblastoma', '', '', '9474-3', '4'),
(50, 'Embryonal Tumors', 'Central nervous system primitive neuroectodermal tumors', 'CNS PNET, NOS', 'Primitive neuroectodermal tumor(PNET) is aneural cresttumor.It is a raretumor, usually occurring in children and young adults under 25 years of age. After successful chemo- or(and) radio- therapy the 5 year survival rate is only 7,6-8percent', 'http://en.wikipedia.org/wiki/CNS_PNET', '9473-3', '4'),
(51, 'Embryonal Tumors', 'Central nervous system primitive neuroectodermal tumors', 'CNS neuroblastoma', '', '', '9500-3', '4'),
(52, 'Embryonal Tumors', 'Central nervous system primitive neuroectodermal tumors', 'CNS ganglioneuroblastoma', '', '', '9490-3', '4'),
(53, 'Embryonal Tumors', 'Central nervous system primitive neuroectodermal tumors', 'Medulloepithelioma', 'Medulloepitheliomais a rare, primitive, fast growingbrain tumourthought to stem fromcellsof theembryonicmedullary cavity.Tumours originating in theciliary bodyof theeyeare referred to as embryonal medulloepitheliomas,ordiktyomas', 'http://en.wikipedia.org/wiki/Medulloepithelioma', '9501-3', '4'),
(54, 'Embryonal Tumors', 'Central nervous system primitive neuroectodermal tumors', 'Ependymoblastoma', 'Primitive neuroectodermal tumor(PNET) is aneural cresttumor.It is a raretumor, usually occurring in children and young adults under 25 years of age. After successful chemo- or(and) radio- therapy the 5 year survival rate is only 7,6-8percent', 'http://en.wikipedia.org/wiki/Ependymoblastoma', '9392-3', '4'),
(55, 'Embryonal Tumors', 'Atypical teratoid/rhabdoid tumor', 'Atypical teratoid/rhabdoid tumor', 'Atypical teratoid rhabdoid tumor(AT/RT) is a raretumorusually diagnosed in childhood. Although usually abrain tumor, AT/RT can occur anywhere in thecentral nervous system(CNS) including thespinal cord. About 60percent will be in theposterior cranial fossa(particularly thecerebellum). One review estimated 52percent posterior fossa, 39percent sPNET (supratentorialprimitive neuroectodermal tumors), 5percentpineal, 2percentspinal, and 2percent multi-focal.', 'http://en.wikipedia.org/wiki/Atypical_teratoid/rhabdoid_tumor', '9508-3', '4'),
(56, 'Tumors of the Cranial and Paraspinal nerves', 'Schwannoma', 'Schwannoma', 'Aschwannoma(also known as an neurilemmoma,:621neurinoma,neurolemmoma,and Schwann cell tumor) is a benignnerve sheath tumorcomposed ofSchwann cells, which normally produce the insulatingmyelin sheathcoveringperipheral nerves', 'http://en.wikipedia.org/wiki/Schwannoma', '9560-0', '1'),
(57, 'Tumors of the Cranial and Paraspinal nerves', 'Neurofibroma', 'Neurofibroma', 'Aneurofibromais a benignnerve sheath tumorin theperipheral nervous system. Usually found in individuals withneurofibromatosis type I(NF1), anautosomal dominantgenetically-inherited disease, they can result in a range of symptoms from physical disfiguration and pain to cognitive disability. Neurofibromas arise from nonmyelinating-typeSchwann cellsthat exhibitbiallelic inactivationof the NF1 gene that codes for the proteinneurofibromin.This protein is responsible for regulating theRAS-mediatedcell growthsignaling pathway. In contrast toschwannomas, another type of tumor arising from Schwann cells, neurofibromas incorporate many additional types of cells and structural elements in addition to Schwann cells, making it difficult to identify and understand all the mechanisms through which they originate and develop', 'http://en.wikipedia.org/wiki/Neurofibroma', '9540-0', '1'),
(58, 'Tumors of the Cranial and Paraspinal nerves', 'Neurofibroma', 'Plexiform Neurofibroma', '', '', '9550-0', '1'),
(59, 'Tumors of the Cranial and Paraspinal nerves', 'Perineurioma', 'Intraneural and benign soft tissue Perineurioma', '', '', '9571-0', '1'),
(60, 'Tumors of the Cranial and Paraspinal nerves', 'Perineurioma', 'Malignant soft tissue Perineurioma', '', '', '9571-3', '2-3'),
(61, 'Tumors of the Cranial and Paraspinal nerves', 'Malignant peripheral nerve sheath tumor MPNST', 'Malignant peripheral nerve sheath tumor MPNST', 'Amalignant peripheral nerve sheath tumor(also known as Malignant schwannoma,Neurofibrosarcoma,and Neurosarcoma) is a form ofcancerof theconnective tissuesurroundingnerves. Given its origin and behavior it is classified as asarcoma. About half the cases are diagnosed in people withneurofibromatosis; the lifetime risk for an MPNST in patients with neurofibromatosis type 1 is 8-13percent]MPNST withrhabdomyoblastomatouscomponent are calledMalignant triton tumors.', 'http://en.wikipedia.org/wiki/Malignant_peripheral_nerve_sheath_tumor', '9540-3', '2-3-4'),
(62, 'Meningeal Tumors', 'Meningioma', 'Meningioma', 'The wordmeningiomawas first used by Harvey Cushing in 1922 to describe a tumor originating from themeninges, the membranous layers surrounding the CNS. Meningiomas are the second most commonprimary neoplasmof thecentral nervous system, arising from the arachnoid cap cells of thearachnoid villiin the meninges.These tumors are usuallybenignin nature; however, they can bemalignant', 'http://en.wikipedia.org/wiki/Meningiomas', '9530-0', '1-2-3'),
(63, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Lipoma', 'Alipomais abenign tumorcomposed ofadipose tissue. It is the most common form ofsoft tissuetumor.Lipomas are soft to the touch, usually movable, and are generally painless. Many lipomas are small (under one centimeter diameter) but can enlarge to sizes greater than six centimeters. Lipomas are commonly found in adults from 40 to 60 years of age, but can also be found in children. Some sources claim that malignant transformation can occur,while others say that this has yet to be convincingly documented', 'http://en.wikipedia.org/wiki/Lipoma', '8850-0', '1'),
(64, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Liposarcoma', 'Liposarcomais amalignanttumorthat arises infat cellsin deepsoft tissue, such as that inside the thigh or in theretroperitoneum.', 'http://en.wikipedia.org/wiki/Liposarcoma', '8850-3', '1-2-3-4'),
(65, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Angiolipoma', '', '', '8861-0', '1-2-3-4'),
(66, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Hibernoma', '', '', '8880-0', '1-2-3-4'),
(67, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Solitary fibrous tumor', '', '', '8815-0', '1-2-3-4'),
(68, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Fibrosarcoma', '', '', '8810-3', '1-2-3-4'),
(69, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'MFH', '', '', '8830-3', '1-2-3-4'),
(70, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Leiomyoma', '', '', '8890-0', '1-2-3-4'),
(71, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Leiomyosarcoma', '', '', '8890-3', '1-2-3-4'),
(72, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Rhabdomyoma', '', '', '8900-0', '1-2-3-4'),
(73, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Rahbdomyosarcoma', '', '', '8900-3', '1-2-3-4'),
(74, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Chondroma', '', '', '9220-0', '1-2-3-4'),
(75, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Osteoma', '', '', '9180-0', '1-2-3-4'),
(76, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Osteochondroma', '', '', '9210-0', '1-2-3-4'),
(77, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Chondrosarcoma', '', '', '9220-3', '1-2-3-4'),
(78, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Osteosarcoma', '', '', '9180-3', '1-2-3-4'),
(79, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Heamangioma', '', '', '9120-0', '1-2-3-4'),
(80, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Epithelioid Haemangioendothelioma', '', '', '9133-1', '1-2-3-4'),
(81, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Angiosarcoma', '', '', '9120-3', '1-2-3-4'),
(82, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Kaposi sarcoma', '', '', '9140-3', '1-2-3-4'),
(83, 'Meningeal Tumors', 'Mesenchymal, non-meningothelial tumors', 'Ewing sarcoma-peripheral primitive neuroectodermal tumor', '', '', '9364-3', '1-2-3-4'),
(84, 'Meningeal Tumors', 'Hemangiopericytoma', 'Hemangiopericytoma', 'Ahemangeopericytoma(HPC) is a type ofsoft tissue sarcomathat originates in thepericytesin the walls ofcapillaries. When inside thenervous system, although not strictly ameningiomatumor, it is ameningealtumor with an especially aggressive behavior.', 'http://en.wikipedia.org/wiki/Hemangiopericytoma', '9150-1', '2'),
(85, 'Meningeal Tumors', 'Hemangiopericytoma', 'Anaplastic Hemangiopericytoma', '', '', '9150-3', '3'),
(86, 'Meningeal Tumors', 'Melanocytic lesions', 'Diffuse melanocytosis and melanomatosis', '', '', '', '1'),
(87, 'Meningeal Tumors', 'Melanocytic lesions', 'Melanocytoma', '', '', '', '2'),
(88, 'Meningeal Tumors', 'Melanocytic lesions', 'Malignant melanoma', '', '', '', '4'),
(89, 'Meningeal Tumors', 'Hemangioblastoma', 'Hemangioblastoma', 'Hemangioblastomas(also known ascapilliary hemangioblastomas) are tumors of the central nervous system that originate from thevascular systemusually during middle-age. Sometimes these tumors occur in other sites such as thespinal cordandretina.They may be associated with other diseases such aspolycythemia(increasedblood cellcount),pancreaticcystsandVon Hippel-Lindau syndrome(VHL syndrome). Hemangioblastomas are most commonly composed ofstromal cellsin small blood vessels and usually occur in thecerebellum,brain stemorspinal cord. They are classed as grade one tumors under theWorld Health Organisations classification system', 'http://en.wikipedia.org/wiki/Hemangioblastoma', '9161-1', '1'),
(90, 'Tumors of the Heamatopoietic System', 'Malignant lymphomas', 'Malignant lymphomas', 'Lymphomais acancerof thelymphocytes, a type of cell that forms part of theimmune system. Typically, lymphomas present as a solidtumorof lymphoid cells. Treatment might involvechemotherapyand in some casesradiotherapyand/orbone marrow transplantation, and can be curable depending on the histology, type, and stage of the disease.[1]These malignant cells often originate inlymph nodes, presenting as an enlargement of the node (a tumor). It can also affect other organs in which case it is referred to as extranodal lymphoma. Extranodal sites include the skin, brain, bowels and bone. Lymphomas are closely related tolymphoid leukemias, which also originate in lymphocytes but typically involve only circulating blood and thebone marrow(where blood cells are generated in a process termedhaematopoesis) and do not usually form static tumors.There are many types of lymphomas, and in turn, lymphomas are a part of the broad group of diseases calledhematological neoplasms.', 'http://en.wikipedia.org/wiki/Lymphoma', '9590-3', ''),
(91, 'Tumors of the Heamatopoietic System', 'Histiocytic tumors', 'Histiocytic tumors', '', '', '', ''),
(92, 'Germ cell tumors', 'CNS germ cell tumors', 'Germinoma', 'Agerminomais a type ofgerm cell tumorwhich is not differentiated upon examination.It may bebenignormalignant.', 'http://en.wikipedia.org/wiki/Germinoma', '9064-3', ''),
(93, 'Germ cell tumors', 'CNS germ cell tumors', 'Teratoma', 'Ateratomais an encapsulatedtumorwithtissueororgancomponents resemblingnormalderivatives of all threegerm layers. There are rare occasions when not all three germ layers are identifiable. The tissues of a teratoma, although normal in themselves, may be quite different from surrounding tissues and may be highly disparate; teratomas have been reported to containhair,teeth,boneand, very rarely, more complex organs such aseyes,torso,andhands,feet, or otherlimbs.', 'http://en.wikipedia.org/wiki/Teratoma', '9080-1', ''),
(94, 'Germ cell tumors', 'CNS germ cell tumors', 'Mature teratoma', 'Amature teratomais a grade 0 teratoma. Mature teratomas are highly variable in form and histology, and may be solid, cystic, or a combination of solid and cystic. A mature teratoma often contains several different types of tissue such asskin,muscle, andbone. Skin may surround a cyst and grow abundanthair(seeDermoid cyst). Mature teratomas generally are benign; malignant mature teratomas are of several distinct types.', 'http://en.wikipedia.org/wiki/Mature_teratoma#Mature_teratoma', '9080-0', ''),
(95, 'Germ cell tumors', 'CNS germ cell tumors', 'Immature Teratoma', 'Animmature teratomais a rare type ofmalignant(cancerous)germ cell tumor(type oftumorthat begins in the cells that give rise tospermoreggs).', 'http://en.wikipedia.org/wiki/Immature_teratoma', '9080-3', ''),
(96, 'Germ cell tumors', 'CNS germ cell tumors', 'Teratoma with malignant transformation', 'A benign grade 0 (mature) teratoma nonetheless has a risk of malignancy. Recurrence with malignantendodermal sinus tumorhas been reported in cases of formerly benign mature teratoma,even in fetiform teratoma and fetus in fetu.[17][18]Squamous cell carcinomahas been found in a mature cystic teratoma at the time of initial surgery.', 'http://en.wikipedia.org/wiki/Teratoma#Malignant_transformation', '9084-3', ''),
(97, 'Germ cell tumors', 'CNS germ cell tumors', 'Yolk sac tumor', 'Endodermal sinus tumor(EST), also known asyolk sactumor(YST), is a member of thegerm cell tumorgroup ofcancers. It is the most common testicular tumor in children under 3, and is also known asinfantile embryonal carcinoma. This age group has a very good prognosis. In contrast to the pure form typical of infants, adult endodermal sinus tumors are often found in combination with other kinds of germ cell tumor, particularlyteratomaandembryonal carcinoma. While pure teratoma is usuallybenign, endodermal sinus tumor ismalignant.', 'http://en.wikipedia.org/wiki/Yolk_sac_tumor', '9071-3', ''),
(98, 'Germ cell tumors', 'CNS germ cell tumors', 'Embryonal carcinoma', 'Embryonal carcinoma is a relatively uncommon type ofgerm cell tumourthat occurs in theovariesandtestes.', 'http://en.wikipedia.org/wiki/Embryonal_carcinoma', '9070-3', ''),
(99, 'Germ cell tumors', 'CNS germ cell tumors', 'Choriocarcinoma', 'Choriocarcinomais a malignant,trophoblasticand aggressivecancer, usually of theplacenta. It is characterized byearly hematogenous spreadto the lungs. It belongs to the malignant end of the spectrum ingestational trophoblastic disease(GTD). It is also classified as agerm cell tumorand may arise in thetestisorovary.', 'http://en.wikipedia.org/wiki/Choriocarcinoma', '9100-3', ''),
(100, 'Tumor Syndromes involving the Nervous System', 'Neurofibromatosis type 1', 'Neurofibromatosis type 1', 'Neurofibromatosistype I(NF-1), formerly known asvon Recklinghausendiseaseafter the researcher (Friedrich Daniel von Recklinghausen) who first documented the disorder, is a humangenetic disorder. It is possibly the most common inherited disorder caused by a single gene. NF-1 is not to be confused withProteus Syndrome, but rather is a separate disorder. It is aRASopathy. In diagnosis it may also be confused withLegius syndrome.', 'http://en.wikipedia.org/wiki/Neurofibromatosis_type_1', '162200 (1433)', ''),
(101, 'Tumor Syndromes involving the Nervous System', 'Neurofibromatosis type 2', 'Neurofibromatosis type 2', 'Neurofibromatosis Type II(or MISME Syndrome, for Multiple InheritedSchwannomas,Meningiomas, andEpendymomas) is aninherited disease. The main manifestation of the disease is the development of symmetric, non-malignantbrain tumorsin the region of thecranial nerve VIII, which is theauditory-vestibular nervethat transmits sensory information from theinner earto thebrain. Most people with this condition also experience problems in theireyes. NF II is caused bymutationsof theMerlingene,which, it seems, influences the form and movement ofcells. The principal treatments consist ofneurosurgicalremoval of the tumors and surgical treatment of the eye lesions. There is no therapy for the underlying disorder of cell function caused by the genetic mutation.', 'http://en.wikipedia.org/wiki/Neurofibromatosis_type_II', '101000 (1433)', ''),
(102, 'Tumor Syndromes involving the Nervous System', 'Von Hippel-Lindau disease and haemangioblastoma', 'Von Hippel-Lindau disease and haemangioblastoma', 'Von Hippel?Lindau(VHL) is arare,autosomal dominantgenetic condition:in whichhemangioblastomasare found in thecerebellum,spinal cord,kidneyandretina. These are associated with several pathologies including renalangioma,renal cell carcinoma (clear cell variety)andpheochromocytoma. VHL results from amutationin thevon Hippel?Lindau tumor suppressorgene on chromosome 3p25.3', 'http://en.wikipedia.org/wiki/Von_Hippel%E2%80%93Lindau_disease', '193300 (1433)', ''),
(103, 'Tumor Syndromes involving the Nervous System', 'Tuberous sclerosis complex and subependymal giant cell astrocytoma (TSC1)', 'Tuberous sclerosis complex and subependymal giant cell astrocytoma (TSC1)', 'Tuberous sclerosis ortuberous sclerosis complex(TSC) is a rare multi-systemgenetic diseasethat causes non-malignant tumors to grow in thebrainand on other vital organs such as thekidneys,heart,eyes,lungs, andskin. A combination of symptoms may includeseizures,developmental delay, behavioral problems, skin abnormalities, lung and kidney disease. TSC is caused by amutationof either of twogenes,TSC1andTSC2, which code for theproteinshamartin and tuberin respectively. These proteins act astumor growth suppressors, agents that regulate cell proliferation and differentiation', 'http://en.wikipedia.org/wiki/Tuberous_sclerosis', '191100', ''),
(104, 'Tumor Syndromes involving the Nervous System', 'Tuberous sclerosis complex and subependymal giant cell astrocytoma (TSC2)', 'Tuberous sclerosis complex and subependymal giant cell astrocytoma (TSC2)', 'Tuberous sclerosis ortuberous sclerosis complex(TSC) is a rare multi-systemgenetic diseasethat causes non-malignant tumors to grow in thebrainand on other vital organs such as thekidneys,heart,eyes,lungs, andskin. A combination of symptoms may includeseizures,developmental delay, behavioral problems, skin abnormalities, lung and kidney disease. TSC is caused by amutationof either of twogenes,TSC1andTSC2, which code for theproteinshamartin and tuberin respectively. These proteins act astumor growth suppressors, agents that regulate cell proliferation and differentiation', 'http://en.wikipedia.org/wiki/Tuberous_sclerosis', '191092 (1433)', ''),
(105, 'Tumor Syndromes involving the Nervous System', 'Li-Fraumeni syndrome ', 'Li-Fraumeni syndrome ', 'Li-Fraumeni syndromeis an extremely rareautosomal dominanthereditary disorder. Named afterFrederick Pei LiandJoseph F. Fraumeni, Jr., the American physicians who first recognized and described the syndrome,Li-Fraumeni syndrome greatly increases susceptibility tocancer.', 'http://en.wikipedia.org/wiki/Li-Fraumeni_syndrome', '151623', ''),
(106, 'Tumor Syndromes involving the Nervous System', 'TP53 germline mutations', 'TP53 germline mutations', '', 'http://en.wikipedia.org/wiki/Li-Fraumeni_syndrome', '191171 (1433)', ''),
(107, 'Tumor Syndromes involving the Nervous System', 'Cowden disease and dysplastic gangliocytoma of the cerebellum/Lhermitte-Duclos disease', 'Cowden disease and dysplastic gangliocytoma of the cerebellum/Lhermitte-Duclos disease', 'Lhermitte-Duclos disease(dysplasticgangliocytomaof the cerebellum, LDD) is arare, slowly growingtumorof thecerebellum, sometimes considered ashamartoma, characterized by diffusehypertrophyof thestratum granulosumof the cerebellum. It is often associated withCowden syndromeand ispathognomonicfor this disease.It was described byJacques Jean Lhermitteand P. Duclos in 1920', 'http://en.wikipedia.org/wiki/Lhermitte%E2%80%93Duclos_disease', '158350 (1433)', ''),
(108, 'Tumor Syndromes involving the Nervous System', 'Turcot Syndrome', 'Turcot Syndrome', '', '', '276300 (1433)', ''),
(109, 'Tumor Syndromes involving the Nervous System', 'Naevoid basal cell carcinoma syndrome', 'Naevoid basal cell carcinoma syndrome', 'Nevoid basal cell carcinoma syndrome (NBCCS), also known asbasal cell nevus syndrome,multiple basal cell carcinoma syndrome,Gorlin syndrome, andGorlin?Goltz syndrome, is an inherited medical condition involving defects within multiple body systems such as theskin,nervous system,eyes,endocrine system, andbones.People with this syndrome are particularly prone to developing a common and usually non-life-threatening form of non-melanomaskin cancers.', 'http://en.wikipedia.org/wiki/Naevoid_basal_cell_carcinoma_syndrome', '109400 (1433)', ''),
(110, 'Tumor Syndromes involving the Nervous System', 'Rhabdoid tumor predisposition syndrome', 'Rhabdoid tumor predisposition syndrome', '', '', '609322', ''),
(111, 'Tumors of the sellar region', 'Craniopharyngioma', 'Craniopharyngioma', 'Craniopharyngiomais a type of braintumorderived frompituitary glandembryonic tissue,that occurs most commonly in children but also in men and women in their 50s and 60s.It arises from nests of odontogenic (tooth-forming) epithelium within the suprasellar/diencephalic region and, therefore, contains deposits ofcalcium, which are evident on anx-ray. Histologically, craniopharyngiomas resembleadamantinomas(the most common tumors of the tooth). Patients may present withbitemporal inferior quadrantanopialeading tobitemporal hemianopia, as the tumor may compress theoptic chiasm. It has a pointprevalenceof approximately 2/100,000', 'http://en.wikipedia.org/wiki/Craniopharyngioma', '9350-1', '1'),
(112, 'Tumors of the sellar region', 'Craniopharyngioma', 'Adamantinomatous Craniopharyngioma', ' ', '', '9351-1', '1'),
(113, 'Tumors of the sellar region', 'Craniopharyngioma', 'Papillary Craniopharyngioma', '', '', '9352-1', '1'),
(114, 'Tumors of the sellar region', 'Granular cell tumor of the neurohypophysis', 'Granular cell tumor of the neurohypophysis', '', '', '9582-0', '1'),
(115, 'Tumors of the sellar region', 'Pituicytoma', 'Pituicytoma', 'Pituicytomais a rarebrain tumor. It grows at the base of the brain from thepituitary gland. This tumor is thought to be derived from theparenchymal cellsof theposterior lobeof the pituitary gland, the so-calledpituicytes. Some researchers believe that they arise from thefolliculostellate cellsin theanterior lobeof the pituitary. As such, it is a low-gradeglioma. It occurs in adults and symptoms includevisual disturbanceandendocrinological dysfunction. They are often mistaken forpituitary adenomaswhich have a similar presentation and occur in the same location. The treatment consists of surgical resection, which is curative in most cases.', 'http://en.wikipedia.org/wiki/Pituicytoma', '9432-1', '1'),
(116, 'Tumors of the sellar region', 'Spindle cell oncocytoma of the adenohypophysis', 'Spindle cell oncocytoma of the adenohypophysis', '', '', '8291-0', '1'),
(117, 'Metastatic tumors of the CNS', 'Metastatic tumors of the CNS', 'Metastatic tumors of the CNS', '', '', '', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `tumors_prov`
--

CREATE TABLE IF NOT EXISTS `tumors_prov` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_tumor` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `tumors_prov`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permission` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `permission`) VALUES
(1, 'root', 'root', 1);
