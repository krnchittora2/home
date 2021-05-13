#Import required libraries
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestClassifier

#Training and testing data set
titanic_train = pd.read_csv('train.csv')
titanic_test = pd.read_csv('test.csv')
y_train = titanic_train['Survived']
category_var = ["Pclass", "Sex", "SibSp", "Parch"]
x_train = pd.get_dummies(titanic_train[category_var])
x_test = pd.get_dummies(titanic_test[category_var])

#Random Forest Classifier Model
model = RandomForestClassifier(n_estimators=100, max_depth=5, random_state=1)
model.fit(x_train, y_train)
print('R^2 =',model.score(x_train,y_train))
y_pred = model.predict(x_test)

#Final csv file
x_pred = titanic_test['PassengerId']
submission = pd.DataFrame({'PassengerId': x_pred,'Survived': y_pred})
submission.to_csv('sub.csv', index=False)

#############################################
#H5 Tech Project Submission by Karan Chittora
#############################################