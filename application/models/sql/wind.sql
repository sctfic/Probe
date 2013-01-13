SELECT
    DATE(sa.utc) AS _Day,
    IFNULL( dd.value * 22.5, 'null' ) AS DominantDirection,
    COUNT(sa.utc) AS SampleCount,
    ROUND(AVG(sa.value), 3) AS SpeedAverage,
    DayMaxSpeedInThisDirection
FROM TA_VARIOUS AS sa -- Speed Average

LEFT JOIN TA_VARIOUS AS dd -- Dominant Direction
    ON (sa.utc = dd.utc AND dd.sen_id = %s)

LEFT JOIN (
    SELECT
        DATE(md.utc) AS MaxDirDay, md.value AS MaxDirection, MAX(ms.value) AS DayMaxSpeedInThisDirection
    FROM TA_VARIOUS AS md -- Max Direction
    LEFT JOIN TA_VARIOUS AS ms -- Max Speed
        ON (md.utc = ms.utc AND ms.sen_id = %s)
    WHERE md.sen_id = %s
    AND md.utc >= %s AND md.utc < DATE_ADD( %s, INTERVAL %s %s )
    GROUP BY MaxDirDay, MaxDirection
) AS msd -- Max Speed & Direction
    ON ( MaxDirDay = DATE(sa.utc) AND msd.MaxDirection = dd.value)

WHERE sa.sen_id = %s
    AND sa.utc >= %s AND sa.utc < DATE_ADD( %s, INTERVAL %s %s )
GROUP BY _Day, DominantDirection
ORDER BY _Day ASC, DominantDirection;