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
   
   SELECT idx, datex, linex, b.PART_NAME partdx, c.LINE_DESC linedx, groupx, partx, byx, stg, a.ss, a.rej, avgppm, totavgppm, a.pflagx, a.seam, a.spi, a.dim, a.oth, a.act, a.c_aes, a.c_func, a.c_dim, a.c_stat, a.procx, a.procdx, a.mcx
   FROM (
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, a.rev_ss ss, a.rev_rej rej, ROUND(((a.rev_rej/a.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm,
       'CBS' pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth, a.rev_act act, a.rev_proc_id procx, b.CBSD_PROC_DESC procdx,  b.CBSD_PROC_MC_TOOL mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat
     FROM fo_review_d a
     LEFT JOIN toy_part_cbsd b ON a.rev_proc_id = b.CBSD_ID
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
     UNION ALL
     SELECT
       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej, ROUND(((c.rev_rej/c.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm,
       'CUS' pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth, a.rev_act act, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat
     FROM fo_review_dc a
     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
     WHERE a.rev_id = '1'
     ) a
   LEFT JOIN toy_part b on a.partx = b.PART_NUM
   LEFT JOIN line c on a.linex = c.LINE_CODE;
   
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