SELECT
    DATE(sa.utc) AS _Day,
    dd.value AS DominantDirection,
    COUNT(sa.utc) AS SampleCount,
    ROUND(AVG(sa.value), 3) AS SpeedAverage,
    DayMaxSpeedInThisDirection
FROM TA_VARIOUS AS sa -- Speed Average

LEFT JOIN TA_VARIOUS AS dd -- Dominant Direction
    ON (sa.utc = dd.utc AND dd.sen_id = %i)

LEFT JOIN (
    SELECT
        DATE(md.utc) AS MaxDirDay, md.value AS MaxDirection, MAX(ms.value) AS DayMaxSpeedInThisDirection
    FROM TA_VARIOUS AS md -- Max Direction
    LEFT JOIN TA_VARIOUS AS ms -- Max Speed
        ON (md.utc = ms.utc AND ms.sen_id = %i)
    WHERE md.sen_id = %i
    AND md.utc BETWEEN $s AND %s
    GROUP BY MaxDirDay, MaxDirection
) AS msd -- Max Speed & Direction
    ON ( MaxDirDay = DATE(sa.utc) AND msd.MaxDirection = dd.value)

WHERE sa.sen_id = %i
AND sa.utc BETWEEN %s AND %s
GROUP BY _Day, DominantDirection
ORDER BY _Day ASC, DominantDirection;


-- SELECT
--     DATE(d.utc) AS _Day,
--     IFNULL( dd.value * 22.5,  'null' ) AS DominantDirection,
--     COUNT(d.utc) AS SampleCount,
--     round(AVG(sa.value), 3) AS SpeedAverage,
--     MAX(ms.value) AS DayMaxSpeedInThisDirection
-- FROM (
--     SELECT DISTINCT utc FROM TA_VARIOUS
--     WHERE utc >= ".$this->dataDB->escape($since)." AND utc < DATE_ADD( ".$this->dataDB->escape($since).", INTERVAL ".$this->dataDB->escape($lenght)." ".$STEP[$step]." )
-- ) AS d -- date
-- LEFT JOIN TA_VARIOUS AS dd -- Dominant Direction
-- ON (d.utc = dd.utc AND dd.sen_id = ".(int)$this->SEN_LST['TA:Arch:Various:Wind:DominantDirection'].")
-- LEFT JOIN TA_VARIOUS AS sa -- Speed Average
-- ON (d.utc = sa.utc AND sa.sen_id = ".(int)$this->SEN_LST['TA:Arch:Various:Wind:SpeedAvg'].")
-- LEFT JOIN TA_VARIOUS AS md -- Max Speed Direction
-- ON (d.utc = md.utc AND md.sen_id = ".(int)$this->SEN_LST['TA:Arch:Various:Wind:HighSpeedDirection']." AND md.value = dd.value)
-- LEFT JOIN TA_VARIOUS AS ms -- Max Speed
-- ON (md.utc = ms.utc AND ms.sen_id = ".(int)$this->SEN_LST['TA:Arch:Various:Wind:HighSpeed'].")
-- GROUP BY _Day, DominantDirection
-- ORDER BY _Day, DominantDirection