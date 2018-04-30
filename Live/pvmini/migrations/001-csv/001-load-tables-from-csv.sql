create table load_tables
    (
        id int auto_increment primary key,
        tilt int default 0,
        wind int default 0,
        snow int default 0,
        maxSpan double default 0.0,
        FCT double default 0.0,
        FCC double default 0.0,
        FCS double default 0.0,
        RCT double default 0.0,
        RCC double default 0.0,
        RCS double default 0.0,
        ballastWidth int default 0,
        purlin double default 0.0,
        girder double default 0.0,
        strut double default 0.0,
        drift double default 0.0,
        fasteners double default 0.0,
        purlinType varchar(128) default '',
        brace int default 0,
        seismic bool default false,
        codeVersion int default 0,
        cellType int default 0,
        roofSnow double default 0.0
    )
;

load data local infile './load_tables_pvmini_60_15.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion
    )
    set cellType = 60
; 

load data local infile './load_tables_pvmini_60_20.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion
    )
    set cellType = 60
; 

load data local infile './load_tables_pvmini_60_25.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion
    )
    set cellType = 60
; 

load data local infile './load_tables_pvmini_60_30.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion
    )
    set cellType = 60
;

load data local infile './load_tables_pvmini_60_35.csv' into table load_tables
    fields terminated by ','
    (
        tilt, wind, snow, maxSpan, FCT, FCC, FCS, RCT, RCC, RCS, ballastWidth, purlin, girder, strut, drift, 
        fasteners, purlinType, brace, seismic, codeVersion
    )
    set cellType = 60
;

update load_tables set roofSnow = 0 where snow = 0;
update load_tables set roofSnow = 15.12 where snow = 20;
update load_tables set roofSnow = 30.24 where snow = 40;
update load_tables set roofSnow = 45.36 where snow = 60;
