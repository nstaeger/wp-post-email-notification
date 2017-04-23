#!/usr/bin/env bash

###################
# HELPER FUNCTION #
###################
svncommit () {
    echo "Add new files to SVN"
    svn stat svndir | grep '^?' | awk '{print $2}' | xargs -I x svn add x@
    echo "Remove deleted files from SVN"
    svn stat svndir | grep '^!' | awk '{print $2}' | xargs -I x svn rm --force x@
    echo "SVN Stats"
    svn stat svndir
    echo "Commit to SVN"
    svn commit --no-auth-cache --username "$1" --password "$2" svndir -m "$3"
}
###################

if [[ -z "$TRAVIS" ]]; then
	echo "Script is only to be run by Travis CI" 1>&2
	exit 1
fi

if [[ -z "$WP_ORG_USERNAME" ]]; then
	echo "WordPress.org username not set" 1>&2
	exit 1
fi

if [[ -z "$WP_ORG_PASSWORD" ]]; then
	echo "WordPress.org password not set" 1>&2
	exit 1
fi

if [[ -z "$TRAVIS_BRANCH" || "$TRAVIS_BRANCH" != "master" ]]; then
	echo "Build branch is required and must be 'master'" 1>&2
	exit 0
fi

PLUGIN="wp-post-email-notification"
PLUGIN_BUILD_PATH="_dist/wp-post-email-notification"
VERSION=$(grep "^ \* Version: " wp-post-email-notification.php | awk '{ print $NF}')

echo "Clean up any previous svn dir"
rm -fR svndir

echo "Checkout the SVN repo"
svn co -q "http://svn.wp-plugins.org/$PLUGIN" svndir

echo "Move out the trunk directory to a temp location ./svn-trunk-tmp"
mv svndir/trunk ./svn-trunk-tmp

echo "Re-create trunk directory"
mkdir svndir/trunk

echo "Copy plugin into trunk from $PLUGIN_BUILD_PATH"
rsync -r -p $PLUGIN_BUILD_PATH/* svndir/trunk

echo "Copy all .svn folder from old trunk to new trunk"
# This is necessary as the Travis container runs Subversion 1.6 which has .svn dirs in every sub dir
cd svndir/trunk/
TARGET=$(pwd)
cd ../../
cd svn-trunk-tmp/
# Find all .svn dirs in sub dirs
SVN_DIRS=`find . -type d -iname .svn`
for SVN_DIR in $SVN_DIRS; do
    SOURCE_DIR=${SVN_DIR/.}
    TARGET_DIR=$TARGET${SOURCE_DIR/.svn}
    TARGET_SVN_DIR=$TARGET${SVN_DIR/.}
    if [ -d "$TARGET_DIR" ]; then
        # Copy the .svn directory to trunk dir
        cp -r $SVN_DIR $TARGET_SVN_DIR
    fi
done
# Back to home dir
cd ../

echo "Remove old trunk from temp location ./svn-trunk-tmp"
rm -fR svn-trunk-tmp

svncommit $WP_ORG_USERNAME $WP_ORG_PASSWORD "automatic deployment for $TRAVIS_COMMIT"

echo "Check if tag already exists for the version $VERSION"
TAG=$(svn ls "https://plugins.svn.wordpress.org/$PLUGIN/tags/$VERSION")
error=$?
if [ $error == 0 ]; then
    echo "Tag already exists for version $VERSION, won't create tag."
else
    echo "Deploying tag for version $VERSION"
    mkdir svndir/tags/$VERSION
    rsync -r -p $PLUGIN_BUILD_PATH/* svndir/tags/$VERSION
    svncommit $WP_ORG_USERNAME $WP_ORG_PASSWORD "create tag for version $VERSION"
fi

echo "Remove SVN temp dir"
rm -fR svndir
