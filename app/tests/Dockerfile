From python:3

LABEL maintainer="Kranthi Kavuri <kranthik123@gmail.com>"

WORKDIR /tests
ADD . /tests/

RUN pip install -r requirements.txt

ENTRYPOINT [ "pytest -v" ]
