#!/usr/bin/env bash

export REPORT_EXIT_STATUS=1
export TESTS='--show-diff'
PROCESSES="$(nproc)"
if [[ "$PROCESSES" -gt 1 ]]; then
    TESTS="$TESTS -j$PROCESSES"
fi

export DONT_FAIL_IF_LEAKED=1

cp ci/run-tests-parallel.php run-tests.php

make test
