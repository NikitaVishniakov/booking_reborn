from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import Column, String, Integer
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from nltk.stem.lancaster import LancasterStemmer

Base = declarative_base()
    class Dict(Base):
        __tablename__ = "dict"
        id = Column(Integer, primary_key = True)
        group = Column(String)
        word = Column(String)
        index = Column(Integer)

    engine = create_engine("sqlite:///dict.db")
    Base.metadata.create_all(bind=engine)

    session = sessionmaker(bind=engine)
    s = session()
def add_to_dict(string):
    