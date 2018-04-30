truncate table load_tables;

load data local infile './new_load_tables_pvmini_60_15.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion, roofSnow
    )
    set cellType = 60, purlin = purlin / 100, girder = girder / 100, strut = strut / 100, drift = drift / 100, 
        fasteners = fasteners / 100, brace = brace / 100
;

load data local infile './new_load_tables_pvmini_60_20.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion, roofSnow
    )
    set cellType = 60, purlin = purlin / 100, girder = girder / 100, strut = strut / 100, drift = drift / 100, 
        fasteners = fasteners / 100, brace = brace / 100
;

load data local infile './new_load_tables_pvmini_60_25.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion, roofSnow
    )
    set cellType = 60, purlin = purlin / 100, girder = girder / 100, strut = strut / 100, drift = drift / 100, 
        fasteners = fasteners / 100, brace = brace / 100
;


load data local infile './new_load_tables_pvmini_60_30.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion, roofSnow
    )
    set cellType = 60, purlin = purlin / 100, girder = girder / 100, strut = strut / 100, drift = drift / 100, 
        fasteners = fasteners / 100, brace = brace / 100
;

load data local infile './new_load_tables_pvmini_60_35.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion, roofSnow
    )
    set cellType = 60, purlin = purlin / 100, girder = girder / 100, strut = strut / 100, drift = drift / 100, 
        fasteners = fasteners / 100, brace = brace / 100
;
