
create table parts (
    id int auto_increment primary key,
    part_type varchar(100) not null default 'rail',
    part_number varchar(100) not null default '',
    name varchar(2048) not null default '',
    rail_type varchar (100) default null,
    min_thickness double default null,
    max_thickness double default null,
    tilt int default null,
    cells int default null,
    rail_length int default null
);

insert into parts values
    /* Rails */
    (null, 'rail', '120004-04200', '4.2 m ProfiPlus05 Rail', 'ProfiPlus', null, null, null, null, 4200),
    (null, 'rail', '120004-06200', '6.2 m ProfiPlus05 Rail', 'ProfiPlus', null, null, null, null, 6200),
    (null, 'rail', '120008-04200', '4.2 m ProfiPlus XT Rail', 'ProfiPlusXT', null, null, null, null, 4200),
    (null, 'rail', '120008-06200', '6.2 m ProfiPlus XT Rail', 'ProfiPlusXT', null, null, null, null, 6200),

    /* Splices */
    (null, 'splice', '129074-000', 'Splice, ProfiPlus, Internal, Kit, A', 'ProfiPlus', null, null, null, null, null),
    (null, 'splice', '129006-000', 'Splice, DN1, Internal, Kit', 'ProfiPlusXT', null, null, null, null, null),

    /* Supports */
    (null, 'support', '159003-003', 'Standard, Triangle, PvMini, Assembly, 15&deg;', null, null, null, 15, null, null),
    (null, 'support', '159003-004', 'Standard, Triangle, PvMini, Assembly, 20&deg;', null, null, null, 20, null, null),
    (null, 'support', '159003-005', 'Standard, Triangle, PvMini, Assembly, 25&deg;', null, null, null, 25, null, null),
    (null, 'support', '159003-006', 'Standard, Triangle, PvMini, Assembly, 30&deg;', null, null, null, 30, null, null),
    (null, 'support', '159003-007', 'Standard, Triangle, PvMini, Assembly, 35&deg;', null, null, null, 35, null, null),
    
    /* Cross Bracing */
    (null, 'brace', '128003-002', 'Cross Brace, PVMini, 60 Cell, Kit', null, null, null, null, 60, null),
    
    /* Module End Clamps */
    (null, 'endClamp', '133160-268', '6.8 mm Laminate Eco6 End Clamp Kit', null, 6.8, 6.8, null, null, null),
    (null, 'endClamp', '133180-280', '8 mm Laminate Eco8 End Clamp Kit', null, 8, 8, null, null, null),
    (null, 'endClamp', '131001-030', 'Rapid2+ End Clamp Assembly', null, 30, 30, null, null, null),
    (null, 'endClamp', '131001-031', 'Rapid2+ End Clamp Assembly', null, 31, 31, null, null, null),
    (null, 'endClamp', '131001-032', 'Rapid2+ End Clamp Assembly', null, 32, 32, null, null, null),
    (null, 'endClamp', '131001-033', 'Rapid2+ End Clamp Assembly', null, 33, 33, null, null, null),
    (null, 'endClamp', '131001-034', 'Rapid2+ End Clamp Assembly', null, 34, 34, null, null, null),
    (null, 'endClamp', '131001-035', 'Rapid2+ End Clamp Assembly', null, 35, 35, null, null, null),
    (null, 'endClamp', '131001-036', 'Rapid2+ End Clamp Assembly', null, 36, 36, null, null, null),
    (null, 'endClamp', '131001-037', 'Rapid2+ End Clamp Assembly', null, 37, 37, null, null, null),
    (null, 'endClamp', '131001-038', 'Rapid2+ End Clamp Assembly', null, 38, 38, null, null, null),
    (null, 'endClamp', '131001-039', 'Rapid2+ End Clamp Assembly', null, 39, 39, null, null, null),
    (null, 'endClamp', '131001-040', 'Rapid2+ End Clamp Assembly', null, 40, 40, null, null, null),
    (null, 'endClamp', '131001-041', 'Rapid2+ End Clamp Assembly', null, 41, 41, null, null, null),
    (null, 'endClamp', '131001-042', 'Rapid2+ End Clamp Assembly', null, 42, 42, null, null, null),
    (null, 'endClamp', '131001-043', 'Rapid2+ End Clamp Assembly', null, 43, 43, null, null, null),
    (null, 'endClamp', '131001-044', 'Rapid2+ End Clamp Assembly', null, 44, 44, null, null, null),
    (null, 'endClamp', '131001-045', 'Rapid2+ End Clamp Assembly', null, 45, 45, null, null, null),
    (null, 'endClamp', '131001-046', 'Rapid2+ End Clamp Assembly', null, 46, 46, null, null, null),
    (null, 'endClamp', '131001-047', 'Rapid2+ End Clamp Assembly', null, 47, 47, null, null, null),
    (null, 'endClamp', '131001-048', 'Rapid2+ End Clamp Assembly', null, 48, 48, null, null, null),

    /* Module Mid Clamps */
    (null, 'midClamp', '133260-268', '6.8 mm Laminate Eco6 Mid Clamp Kit', null, 6.8, 6.8, null, null, null),
    (null, 'midClamp', '133280-280', '8 mm Laminate Eco8 Mid Clamp Kit', null, 8, 8, null, null, null),
    (null, 'midClamp', '135002-002', 'Grounding Rapid 2+ Mid Clamp Assembly', null, 30, 39, null, null, null),
    (null, 'midClamp', '135002-003', 'Grounding Rapid 2+ Mid Clamp Assembly', null, 40, 50, null, null, null)
;
