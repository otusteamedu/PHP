#!/bin/sh

. "$( dirname "$( readlink -e "$0" )" )/.deployment.options" || exit 1
test "${DIRBASE%%/}" || exit 1

exec > "$DIRBASE/depl-$(date +%Y%m%d-%H%M%S.%02N).log" 2>&1

(
  set -e

  rm -rf "$DIRBASE/export"

  svn export "$SVNBASE/trunk" "$DIRBASE/export"
  svn export --force "$SVNBASE/config/remote" "$DIRBASE/export"

  "$DIRBASE/export/tools/rebuild.sh"

  rm -rf "$DIRBASE/export/tools" "$DIRBASE/export/config"
) || exit $?

export LANG=$( locale -uU || echo "en_US.UTF-8" )
test -r "$HOME/.ssh/agent" && . "$HOME/.ssh/agent"
{
  /usr/bin/rsync -Fxtcrv --no-motd --iconv="." --rsh="ssh -T" --rsync-path='$HOME/bin/rsyncd' -- \
    "$DIRBASE/export/" "$REMBASE/" && \
    /usr/bin/ssh "${REMBASE%%::*}" -- '/usr/bin/find "$HOME/tmp/smarty/cache/" "$HOME/tmp/smarty/templates/" -type f -delete;
      /usr/local/bin/composer install --no-progress --no-dev'
}
