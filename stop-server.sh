echo "stopping server"
# shellcheck disable=SC2046
kill $(sudo lsof -t -i:8000)

echo "stopping server"
# shellcheck disable=SC2046
kill $(sudo lsof -t -i:9000)

echo "server has stopped running"
