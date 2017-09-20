#!/bin/bash -ex

echo "Workspace: $WORKSPACE"
echo "Git commit: $GIT_COMMIT"
echo "Git prev commit: $GIT_PREVIOUS_COMMIT"
echo "Git prev success commit: $GIT_PREVIOUS_SUCCESSFUL_COMMIT"
echo "Git branch: $GIT_BRANCH"
echo "Git local branch: $GIT_LOCAL_BRANCH"
echo "Git URL: $GIT_URL"
echo "Git comitter: $GIT_COMMITTER_NAME"
echo "Git author: $GIT_AUTHOR_NAME"
echo "Git comitter email: $GIT_COMMITTER_EMAIL"
echo "Git author email: $GIT_AUTHOR_EMAIL"

case "$GIT_BRANCH" in
    "origin/master")
        echo "!!! You are attempting to build from master !!!"
        ;;
    *)
        echo "Invalid branch!"
        exit 1
esac

# RightScale variables
RS_API_ENDPOINT="us-4.rightscale.com"
RS_OPS_ACCOUNT="107157"
RS_OPS_ACCOUNT_TOKEN="621d9357edb9b87f937f70d13ccc6eed183e3b3f"
RS_OPS_ACCOUNT_SCRIPT_HREF="/api/right_scripts/600180004"
RS_TRAIN_ACCOUNT="79677"
RS_TRAIN_ACCOUNT_TOKEN="ca5f6bab8395ff0ee9dde237480ee20c6a7ce321"
RS_TRAIN_ACCOUNT_SCRIPT_HREF="/api/right_scripts/599590004"

# Check PHP syntax
find . -type f -name "*.php" -exec php -l {} \;

# Get RightScale instance HREF
INSTANCE_HREF=$(/usr/bin/rsc --refreshToken $RS_TRAIN_ACCOUNT_TOKEN --host $RS_API_ENDPOINT --account=$RS_TRAIN_ACCOUNT cm15 show  /api/deployments/789352004/servers/1611696004 | jq --raw-output '.links[] | if .rel == "current_instance" then .href else empty end')
echo "RightScale Instance is: $INSTANCE_HREF"

# Execute RightScript
/usr/bin/rsc --refreshToken $RS_TRAIN_ACCOUNT_TOKEN --host $RS_API_ENDPOINT --account=$RS_TRAIN_ACCOUNT cm15 run_executable $INSTANCE_HREF "right_script_href=/api/right_scripts/599590004" "inputs[][name]=APP_REPO" "inputs[][value]=text:https://github.com/freddy-offis/demo_app.git" "inputs[][name]=APP_NAME" "inputs[][value]=text:demo_app" "inputs[][name]=APP_BRANCH" "inputs[][value]=text:master" "inputs[][name]=MYSQL_ROOT_PASSWORD" "inputs[][value]=text:root" "inputs[][name]=APP_BRANCH" "inputs[][value]=text:master" "inputs[][name]=MYSQL_APP_DB_NAME" "inputs[][value]=text:demo_app"

