From python:3

LABEL maintainer="Kranthi Kavuri <kranthik123@gmail.com>"

WORKDIR /app/tests
ADD app/tests/. /app/tests/

RUN pip install -r ./requirements.txt

ENTRYPOINT [ "pytest -v" ]
