SELECT
    FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP(sa.utc) / (%s), 0)*(%s)+(%s) ) AS UTC_grp,
    IFNULL( dd.value * 22.5, 'null' ) AS DominantDirection,
    COUNT(sa.utc) AS SampleCount,
    ROUND(AVG(sa.value), 3) AS SpeedAverage,
    UTC_grpMaxSpeedInThisDirection
FROM TA_VARIOUS AS sa -- Speed Average

LEFT JOIN TA_VARIOUS AS dd -- Dominant Direction
    ON (sa.utc = dd.utc AND dd.sen_id = %s)

LEFT JOIN (
    SELECT
         DATE(md.utc) AS MaxDir_UTC, md.value AS MaxDirection, MAX(ms.value) AS UTC_grpMaxSpeedInThisDirection
    FROM TA_VARIOUS AS md -- Max Direction
    LEFT JOIN TA_VARIOUS AS ms -- Max Speed
        ON (md.utc = ms.utc AND ms.sen_id = %s)
    WHERE md.sen_id = %s
    AND md.utc >= '%s' AND md.utc < '%s'
    GROUP BY MaxDir_UTC, MaxDirection
) AS msd -- Max Speed & Direction
    ON ( MaxDir_UTC = DATE(sa.utc) AND msd.MaxDirection = dd.value)

WHERE sa.sen_id = %s
    AND sa.utc >= '%s' AND sa.utc < '%s'
GROUP BY UTC_grp, DominantDirection
ORDER BY UTC_grp ASC, DominantDirection;