SELECT
  DATE(d.utc) AS _Day,
  dd.value AS DominantDirection,
  COUNT(d.utc) AS SampleCount,
  round(AVG(sa.value), 3) AS SpeedAverage,
  MAX(ms.value) AS DayMaxSpeedInThisDirection
FROM (
 SELECT DISTINCT utc FROM TA_VARIOUS
 WHERE utc >= '2013-01-01' AND utc < DATE_ADD( '2013-01-01', INTERVAL 2 DAY )
) AS d -- date
LEFT JOIN TA_VARIOUS AS dd -- Dominant Direction
ON (d.utc = dd.utc AND dd.sen_id = 12)
LEFT JOIN TA_VARIOUS AS sa -- Speed Average
ON (d.utc = sa.utc AND sa.sen_id = 9)
LEFT JOIN TA_VARIOUS AS md -- Max Speed Direction
ON (d.utc = md.utc AND md.sen_id = 11 AND md.value = dd.value)
LEFT JOIN TA_VARIOUS AS ms -- Max Speed
ON (md.utc = ms.utc AND ms.sen_id = 10)
GROUP BY _Day, DominantDirection
ORDER BY _Day, DominantDirection


--  9  SpeedAvg
-- 12  DominantDirection
-- 10  HighSpeed
-- 11  HighSpeedDirection

SELECT * 
FROM  `TA_VARIOUS` 
WHERE (SEN_ID = 9 OR SEN_ID=12)
AND UTC >=  '2012-12-29T00:00:00'
AND UTC <=  '2012-12-30T00:00:00'

LIMIT 0 , 30