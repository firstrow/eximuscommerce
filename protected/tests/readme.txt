Here are files to help run tests.
All tests are stored in modules/*/tests/*
To run tests execute next command:
    cd /path/to/system/protected/test
    phing
This command will copy all fixture files to protected/tests/fixtures and
run all tests.

Notice: Do not save fixtures or tests in protected/tests/,
use module separated structure. Fore more details see protected/modules/pages/tests directory.
