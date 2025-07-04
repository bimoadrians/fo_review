	SELECT sc.PART_NAME partdx, sa.*
	 FROM (
	  SELECT a.toy_part_id idx, a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre nstre, a.fc_poi fcpoi, a.fc_desc fcdesc, a.fc_size fcsize,
	  a.fc_allow fcallow, a.fc_stre fcstre
	   FROM toy_part_pis a
	  ) sa
	LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
	WHERE 1=1;

	SELECT a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre, a.fc_poi fcpoi, a.fc_desc fdesc, a.fc_size fcsize,
	a.fc_allow fcallow, a.fc_stre fcstre
	 FROM toy_part_pis a;
	 
	SELECT IFNULL(COUNT(*),0) rec_count
	FROM toy_part_pis;