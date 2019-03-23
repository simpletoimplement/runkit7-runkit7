#!/usr/bin/env bash

export REPORT_EXIT_STATUS=1
export TESTS='--show-diff'
PROCESSES="$(nproc)"
if [[ "$PROCESSES" -gt 1 ]]; then
    TESTS="$TESTS -j$PROCESSES"
fi

cp ci/run-tests-parallel.php run-tests.php

make test
