SELECT ABS(DATEDIFF(MAX(`date`), MIN(`date`))) AS 'uptime' FROM db_epham.`member_history`;