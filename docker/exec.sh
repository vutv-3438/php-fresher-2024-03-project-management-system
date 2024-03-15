#!/bin/bash

# Kiểm tra số lượng tham số
if [ "$#" -ne 1 ]; then
    echo "Sử dụng: $0 <container_id_or_name>"
    exit 1
fi

# Lấy ID hoặc tên container từ tham số dòng lệnh
container="$1"

# Kiểm tra xem container có tồn tại không
docker inspect "$container" > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "Container '$container' không tồn tại."
    exit 1
fi

# Exec vào container
docker exec -it "$container" /bin/bash
