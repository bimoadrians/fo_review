	SELECT sa.*, sc.PART_NAME partdx, sb.LINE_DESC linedx, sb.LINE_PREF unitx
	 FROM (
	   SELECT sa.idx, sa.partx, sa.linex, sa.groupx, sa.byx, sa.avgppm
	   FROM (        
	     SELECT a.rev_id idx, a.rev_part partx, a.rev_line linex, a.rev_group groupx, IFNULL(a.rev_by, '') byx, ROUND((a.rev_avgppm),0) avgppm
	     FROM fo_review_h a
	       LEFT JOIN fo_review_d b ON a.rev_id = b.rev_id
	       WHERE a.rev_date ='2025-06-16'
	   ) sa GROUP BY sa.idx, sa.partx, sa.linex, sa.groupx
	 ) sa 
	 LEFT JOIN line sb ON sa.linex = sb.LINE_CODE
	 LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
	 WHERE 1=1;
   
   SELECT idx, datex, linex, b.PART_NAME partdx, c.LINE_DESC linedx, groupx, partx, a.ndesc, a.ndim, a.nstre, a.fcpoi, a.fcdesc, a.fcsize, a.fcallow,
	a.fcstre, byx, stg, a.ss, a.rej, avgppm, totavgppm, a.pflagx, a.seam, a.spi, a.dim, a.oth, a.act, a.c_aes, a.c_func, a.c_dim, a.c_stat, a.procx,
	a.procdx, a.mcx
   FROM (
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, a.rev_ss ss, a.rev_rej rej,
		 ROUND(((a.rev_rej/a.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm, a.pflag pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth,
		 a.rev_act act, a.rev_proc_id procx, b.CBSD_PROC_DESC procdx,  b.CBSD_PROC_MC_TOOL mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim,
		 a.rev_c_stat c_stat, '' ndesc, '' ndim, '' nstre, '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre
     FROM fo_review_d a
     LEFT JOIN toy_part_cbsd b ON a.rev_proc_id = b.CBSD_ID
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej,
		 ROUND(((c.rev_rej/c.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm, a.pflag pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth,
		 a.rev_act act, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat,
		 '' ndesc, '' ndim, '' nstre, '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre
     FROM fo_review_dc_aes a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej,
		 ROUND(((c.rev_rej/c.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm, a.pflag pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth,
		 a.rev_act act, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat,
		 '' ndesc, '' ndim, '' nstre, '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre
     FROM fo_review_dc_fun a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej,
		 ROUND(((c.rev_rej/c.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm, a.pflag pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth,
		 a.rev_act act, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat,
		 '' ndesc, '' ndim, '' nstre, '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre
     FROM fo_review_dc_dim a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     ) a
   LEFT JOIN toy_part b on a.partx = b.PART_NUM
   LEFT JOIN line c on a.linex = c.LINE_CODE;
   
   SELECT idx, datex, linex, b.PART_NAME partdx, c.LINE_DESC linedx, groupx, partx, byx, stg, a.ss, a.rej, avgppm, totavgppm,
	a.seam, a.spi, a.dim, a.oth, a.act, a.pflagx, a.procx, a.procdx, a.mcx,
	a.rev_finding, a.ndesc, a.ndim, a.nstre, a.fcpoi, a.fcdesc, a.fcsize, a.fcallow, a.fcstre, a.rev_1, a.rev_2, a.rev_3, a.rev_4, a.rev_5, a.c_stat
   FROM (
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, a.rev_ss ss, a.rev_rej rej,
		 ROUND(((a.rev_rej/a.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth, a.rev_act act,
       'CBS' pflagx, a.rev_proc_id procx, b.CBSD_PROC_DESC procdx,  b.CBSD_PROC_MC_TOOL mcx, '' rev_finding, '' ndesc, '' ndim, '' nstre,
		 '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre, '' rev_1, '' rev_2, '' rev_3, '' rev_4,
		 '' rev_5, '' c_stat
     FROM fo_review_d a
     LEFT JOIN toy_part_cbsd b ON a.rev_proc_id = b.CBSD_ID
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, '' ss, '' rej, '' avgppm,
		 '' totavgppm, '' seam, '' spi, '' dim, '' oth, '' act,
       'AES' pflagx, a.rev_proc_id procx, '' procdx, '' mcx, a.rev_aes_finding rev_finding, '' ndesc, '' ndim, '' nstre,
		 '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre, '' rev_1, '' rev_2, '' rev_3, '' rev_4, '' rev_5, a.rev_aes_stat c_stat
     FROM fo_review_dc_aes a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, '' ss, '' rej, '' avgppm,
		 '' totavgppm, '' seam, '' spi, '' dim, '' oth, '' act,
       'FUN' pflagx, a.rev_proc_id procx, '' procdx, '' mcx, a.rev_fun_finding rev_finding, '' ndesc, '' ndim, '' nstre,
		 '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre, '' rev_1, '' rev_2, '' rev_3, '' rev_4, '' rev_5,
		 a.rev_fun_stat c_stat
     FROM fo_review_dc_fun a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     UNION ALL
     SELECT
       a.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, '' ss, '' rej, '' avgppm,
		 '' totavgppm, '' seam, '' spi, '' dim, '' oth, '' act,
       'DIM' pflagx, a.rev_proc_id procx, '' procdx, '' mcx, '' rev_finding, a.note_desc ndesc, a.note_dim ndim, a.note_stre nstre, a.fc_poi fcpoi,
		 a.fc_desc fcdesc, a.fc_size fcsize, a.fc_allow fcallow, a.fc_stre fcstre, a.rev_1 rev_1, a.rev_2 rev_2, a.rev_3 rev_3, a.rev_4 rev_4, a.rev_5 rev_5,
		 '' c_stat
     FROM fo_review_dc_dim a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     UNION ALL
     SELECT
       a.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, '' ss, '' rej, '' avgppm, '' totavgppm,
		 '' seam, '' spi, '' dim, '' oth, '' act,
       'DMS' pflagx, a.rev_proc_id procx, '' procdx, '' mcx, '' rev_finding, '' ndesc, '' ndim, '' nstre, '' fcpoi, '' fcdesc, '' fcsize, '' fcallow, '' fcstre, '' rev_1,
		 '' rev_2, '' rev_3, '' rev_4, '' rev_5, a.rev_dim_stat c_stat
     FROM fo_review_dc_dim_stat a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     ) a
   LEFT JOIN toy_part b on a.partx = b.PART_NUM
   LEFT JOIN line c on a.linex = c.LINE_CODE;
   
   SELECT IFNULL(COUNT(*),0) rec_count
   FROM fo_review_h
   WHERE rev_date='2025-07-17' 
   AND rev_line='08'
   AND rev_group='A'
   AND rev_part='11033-48035'
   AND rev_stage='PP'
   AND rev_by='Bimo';
   
   SELECT IFNULL(COUNT(*),0) pis_count
   FROM toy_part_pis
   WHERE part_num='11033-48035';
   
   INSERT INTO `fo_review_dc_dim` (`rev_id`, `rev_proc_id`, `rev_1`, `rev_2`, `rev_3`, `rev_4`, `rev_5`, `rev_dim_stat`, `note_desc`, `note_dim`, `note_stre`, `fc_poi`, `fc_desc`, `fc_size`, `fc_allow`, `fc_stre`,
	`add_date`, `add_id`) 
   SELECT '$idx' aidx, toy_part_id procx, '' rev_1, '' rev_2, '' rev_3, '' rev_4, '' rev_5, '0' c_stat, note_desc ndesc, note_dim ndim, note_stre nstre, fc_poi fcpoi, fc_desc fcdesc, fc_size fcsize, fc_allow fcallow,
	fc_stre fcstre, NOW() addx, '$useridx' adux
   FROM toy_part_pis
   WHERE part_num = '$rev_part';
   
   SELECT *
   FROM toy_part_pis
   WHERE part_num = '11033-88735';
   
   SELECT rev_id idx
	FROM fo_review_h
	WHERE rev_part='11033-88735';
	
	SELECT rev_proc_id procx
	FROM fo_review_dc_dim
	ORDER BY procx DESC
	LIMIT 1;
	
	UPDATE fo_review_dc_aes
   SET rev_aes_finding='a', rev_aes_stat='0', mod_date=NOW(), mod_id='161' 
   WHERE rev_id='1' AND rev_proc_id='AE1';
	
	INSERT INTO `fo_review_dc_dim` (`rev_id`, `rev_proc_id`, `rev_1`, `rev_2`, `rev_3`, `rev_4`, `rev_5`, `rev_dim_stat`, `note_desc`, `note_dim`, `note_stre`, `fc_poi`, `fc_desc`, `fc_size`, `fc_allow`, `fc_stre`,
	`add_date`, `add_id`)
   SELECT '1' aidx, toy_part_id procx, '' rev_1, '' rev_2, '' rev_3, '' rev_4, '' rev_5, '0' c_stat, note_desc ndesc, note_dim ndim, note_stre nstre, fc_poi fcpoi, fc_desc fcdesc, fc_size fcsize,
	fc_allow fcallow, fc_stre fcstre, NOW() addx, '161' adux
	FROM toy_part_pis
   WHERE part_num = '11033-88735';
   
	SELECT (IFNULL(SUM(ROUND((rev_avgppm),0)),0) / IFNULL(COUNT(*),0)) avgppm
	FROM fo_review_d
	WHERE rev_id='1';
	
	UPDATE fo_review_h
   SET rev_avgppm='(ROUND((352,33333333),0)'
   WHERE rev_id='1';
   
	INSERT INTO `fo_review_dc` (`rev_id`, `rev_proc_id`, `rev_proc`, `rev_c_aes`, `rev_c_func`, `rev_c_dim`, `rev_c_stat`, `add_date`, `add_id`) 
	SELECT '2' aidx, 'DC1' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, '2025-06-18 01:48:44' addx, '161' adux UNION ALL
	SELECT '2' aidx, 'DC2' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, '2025-06-18 01:48:44' addx, '161' adux UNION ALL
	SELECT '2' aidx, 'DC3' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, '2025-06-18 01:48:44' addx, '161' adux UNION ALL
	SELECT '2' aidx, 'DC4' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, '2025-06-18 01:48:44' addx, '161' adux UNION ALL
	SELECT '2' aidx, 'DC5' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, '2025-06-18 01:48:44' addx, '161' adux
	;
	
	SELECT rev_ss ss, rev_rej rej
   FROM fo_review_d
 	WHERE rev_id='2' AND rev_proc_id='3192';