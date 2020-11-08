#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
if [[ -f ${DIR}/../vendor/cebe/markdown/inline/EmphStrongTrait.php ]] && [[ -f ${DIR}/fix_latex_parse.patch ]]
then
    echo "==> applying fix_latex_parse.patch..."
    patch -p0 ${DIR}/../vendor/cebe/markdown/inline/EmphStrongTrait.php ${DIR}/fix_latex_parse.patch
fi
echo "==> exiting..."