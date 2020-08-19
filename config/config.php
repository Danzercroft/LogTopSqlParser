<?php

const PATH_TO_LOG_FILES = 'C:\\Users\\v.buralov\\Desktop\\logs_bp\\';

const DB_CONNECTION = [
	'driver'   => 'sqlite',
	'database' => 'LogTopSql.db',
	'prefix'   => '',
	'charset' => 'utf8'
];

//GOOGLE API
const APP_NAME = 'QuerryLogger';
const AUTH_CONFIG_FILE = 'credentials.json';
const SPREAD_SHEET_ID = '1wy5uEKKBp7xyZySY1u2EKzJ3_V61hQV1yRW8Fsq9jg4';

const MIN3_QUERY_LIST = 'Idle in transaction';
const MIN10_QUERY_LIST = 'test1';

const PG_TERMINATE_BACKEND = 0;
const NOW = 1;
const DURATION = 2;
const DATID = 3;
const DATNAME = 4;
const PID = 5;
const USESYSID = 6;
const USENAME = 7;
const APPLICATION_NAME = 8;
const CLIENT_ADDR = 9;
const CLIENT_HOSTNAME = 10;
const CLIENT_PORT = 11;
const BACKEND_START = 12;
const XACT_START = 13;
const QUERY_START = 14;
const STATE_CHANGE = 15;
const WAIT_EVENT_TYPE = 16;
const WAIT_EVENT = 17;
const STATE = 18;
const BACKEND_XID = 19;
const BACKEND_XMIN = 20;
const QUERY = 21;