#Required libraries
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestRegressor

#Error metrics
from sklearn.metrics import mean_squared_error
from sklearn.metrics import mean_absolute_error
def mean_absolute_percentage_error(y_true, y_pred): 
    y_true, y_pred = np.array(y_true), np.array(y_pred)
    return np.mean(np.abs((y_true - y_pred) / y_true)) * 100

#Training data preparation
houses_train = pd.read_csv('train.csv')
houses_train['Alley'] = houses_train['Alley'].fillna('No Alley')
houses_train['MasVnrType'] = houses_train['MasVnrType'].fillna('No Masonary')
houses_train['BsmtQual'] = houses_train['BsmtQual'].fillna('No Basement')
houses_train['BsmtCond'] = houses_train['BsmtCond'].fillna('No Basement')
houses_train['BsmtExposure'] = houses_train['BsmtExposure'].fillna('No Basement')
houses_train['BsmtFinType1'] = houses_train['BsmtFinType1'].fillna('No Basement')
houses_train['BsmtFinType2'] = houses_train['BsmtFinType2'].fillna('No Basement')
houses_train['FireplaceQu'] = houses_train['FireplaceQu'].fillna('No Fireplace')
houses_train['GarageType'] = houses_train['GarageType'].fillna('No Garage')
houses_train['GarageFinish'] = houses_train['GarageFinish'].fillna('No Garage')
houses_train['GarageQual'] = houses_train['GarageQual'].fillna('No Garage')
houses_train['GarageCond'] = houses_train['GarageCond'].fillna('No Garage')
houses_train['GarageYrBlt'] = houses_train['GarageYrBlt'].fillna(0)
houses_train['PoolQC'] = houses_train['PoolQC'].fillna('No Pool')
houses_train['Fence'] = houses_train['Fence'].fillna('No Fence')
houses_train['MiscFeature'] = houses_train['MiscFeature'].fillna('No Feature')
houses_train['MSSubClass'] = houses_train['MSSubClass'].map(str)
houses_train = pd.get_dummies(houses_train)
houses_train = houses_train.dropna(axis=0)

#Dependent varible for training data
y_train = np.array(houses_train['SalePrice'])
houses_train = houses_train.drop('SalePrice',axis=1)

#Testing data preparation
houses_test = pd.read_csv('test.csv')
houses_test['Alley'] = houses_test['Alley'].fillna('No Alley')
houses_test['MasVnrType'] = houses_test['MasVnrType'].fillna('No Masonary')
houses_test['BsmtQual'] = houses_test['BsmtQual'].fillna('No Basement')
houses_test['BsmtCond'] = houses_test['BsmtCond'].fillna('No Basement')
houses_test['BsmtExposure'] = houses_test['BsmtExposure'].fillna('No Basement')
houses_test['BsmtFinType1'] = houses_test['BsmtFinType1'].fillna('No Basement')
houses_test['BsmtFinType2'] = houses_test['BsmtFinType2'].fillna('No Basement')
houses_test['FireplaceQu'] = houses_test['FireplaceQu'].fillna('No Fireplace')
houses_test['GarageType'] = houses_test['GarageType'].fillna('No Garage')
houses_test['GarageFinish'] = houses_test['GarageFinish'].fillna('No Garage')
houses_test['GarageQual'] = houses_test['GarageQual'].fillna('No Garage')
houses_test['GarageCond'] = houses_test['GarageCond'].fillna('No Garage')
houses_test['GarageYrBlt'] = houses_test['GarageYrBlt'].fillna(0)
houses_test['PoolQC'] = houses_test['PoolQC'].fillna('No Pool')
houses_test['Fence'] = houses_test['Fence'].fillna('No Fence')
houses_test['MiscFeature'] = houses_test['MiscFeature'].fillna('No Feature')
houses_test['MSSubClass'] = houses_test['MSSubClass'].map(str)
houses_test['MSZoning'] = houses_test['MSZoning'].fillna('No Zoning')
houses_test['LotFrontage'] = houses_test['LotFrontage'].fillna(0)
houses_test['Utilities'] = houses_test['Utilities'].fillna('No Utility')
houses_test['Exterior1st'] = houses_test['Exterior1st'].fillna('No Exterior')
houses_test['Exterior2nd'] = houses_test['Exterior2nd'].fillna('No Exterior')
houses_test['MasVnrArea'] = houses_test['MasVnrArea'].fillna(0)
houses_test['BsmtFinSF1'] = houses_test['BsmtFinSF1'].fillna(0)
houses_test['BsmtFinSF2'] = houses_test['BsmtFinSF2'].fillna(0)
houses_test['TotalBsmtSF'] = houses_test['TotalBsmtSF'].fillna(0)
houses_test['BsmtFullBath'] = houses_test['BsmtFullBath'].fillna(0)
houses_test['BsmtHalfBath'] = houses_test['BsmtHalfBath'].fillna(0)
houses_test['KitchenQual'] = houses_test['KitchenQual'].fillna('No Kitchen')
houses_test['Functional'] = houses_test['Functional'].fillna('No Functional')
houses_test['GarageCars'] = houses_test['GarageCars'].fillna(0)
houses_test['GarageArea'] = houses_test['GarageArea'].fillna(0)
houses_test['SaleType'] = houses_test['SaleType'].fillna('No Sale')
houses_test['BsmtUnfSF']= houses_test['BsmtUnfSF'].fillna(0)
houses_test = pd.get_dummies(houses_test)

#Matching training and testing data
houses_train.insert(37,'MSSubClass_150',0,True)
houses_train.insert(54,'MSZoning_No Zoning',0,True)
houses_train.insert(72,'Utilities_No Utility',0,True)
houses_train.insert(160,'Exterior1st_No Exterior',0,True)
houses_train.insert(176,'Exterior2nd_No Exterior',0,True)
houses_train.insert(254,'KitchenQual_No Kitchen',0,True)
houses_train.insert(261,'Functional_No Functional',0,True)
houses_train.insert(317,'SaleType_No Sale',0,True)

x = 0
while True:
    try:
        if houses_train.columns[x]!=houses_test.columns[x]:
            houses_test.insert(x,houses_train.columns[x],0,True)
        x += 1
    except:
        break

#Training and testing data for the model
x_train = houses_train.copy()
ind_var = list(x_train.columns)
x_train = np.array(x_train)
x_train = x_train.transpose()[1:].transpose()

x_test = houses_test.copy()
ind_var_test = list(x_test.columns)
x_test = np.array(x_test)
x_test = x_test.transpose()[1:].transpose()

#Random Forest Regressor model
model = RandomForestRegressor(n_estimators = 1000, random_state = 42)
model.fit(x_train, y_train)
print('R-squared for the model is',model.score(x_train, y_train))
y_pred = model.predict(x_test)
submission = pd.DataFrame({'Id': houses_test['Id'],'SalePrice': y_pred})
submission.to_csv('sub0.csv', index=False)

#############################################
#H5 Tech Project Submission by Karan Chittora
#############################################