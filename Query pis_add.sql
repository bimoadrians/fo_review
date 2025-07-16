	SELECT sc.PART_NAME partdx, sa.*
	 FROM (
	  SELECT a.toy_part_id idx, a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre nstre, a.fc_poi fcpoi, a.fc_desc fcdesc, a.fc_size fcsize,
	  a.fc_allow fcallow, a.fc_stre fcstre
	   FROM toy_part_pis a
	  ) sa
	LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
	WHERE 1=1;
	
	SELECT a.toy_part_id idx, a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre nstre, a.fc_poi fcpoi, a.fc_desc fcdesc, a.fc_size fcsize,
	a.fc_allow fcallow, a.fc_stre fcstre
	FROM toy_part_pis a
	LEFT JOIN fo_review_dc_dim b ON a.part_num = b.part_num
	WHERE a.part_num = '11033-88735'
	GROUP BY a.toy_part_id;

	SELECT a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre, a.fc_poi fcpoi, a.fc_desc fdesc, a.fc_size fcsize,
	a.fc_allow fcallow, a.fc_stre fcstre
	 FROM toy_part_pis a;
	 
	SELECT IFNULL(COUNT(*),0) style_count
	FROM toy_part_pis
	WHERE part_num = '11033-88735';