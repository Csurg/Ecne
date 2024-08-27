import React, { useState, useEffect } from 'react';
import { ActivityIndicator, View, Text, TextInput, Button, StyleSheet, Alert, FlatList, TouchableOpacity } from 'react-native';
import {NavigationContainer, useIsFocused} from '@react-navigation/native';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useFocusEffect } from '@react-navigation/native';
import { Picker } from '@react-native-picker/picker';

const SITE = 'https://ecne.stud.vts.su.ac.rs/epets/react/';

let asyncIdUser = null;

const Stack = createNativeStackNavigator();

const storeData = async (key, value) => {
  try {
    await AsyncStorage.setItem(key, JSON.stringify(value));
    console.log('Data saved successfully');
  } catch (error) {
    console.error('Error saving data: ', error);
  }
};

// Get data
const getData = async (key) => {
  try {
    const value = await AsyncStorage.getItem(key);
    if (value !== null) {
      // Data found
      return JSON.parse(value);
    } else {
      // Data not found
      console.log('No data found for the key: ', key);
    }
  } catch (error) {
    console.error('Error retrieving data: ', error);
  }
};

// Remove data
const removeData = async (key) => {
  try {
    await AsyncStorage.removeItem(key);
    console.log('Data removed successfully');
  } catch (error) {
    console.error('Error removing data: ', error);
  }
};


const MyStack = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator>
      <Stack.Screen
          name="Login"
          component={LoginScreen}
          options={{ title: 'Log in' }}
        />
        <Stack.Screen
          name="MyPets"
          component={MyPetsScreen}
          options={{ title: 'My Pets' }}
        />
        <Stack.Screen
          name="PetData"
          component={PetDataScreen}
          options={{ title: 'Pet data' }}
        />
        <Stack.Screen
          name="EditPet"
          component={EditPetScreen}
          options={{ title: 'Edit' }}
        />
        <Stack.Screen
          name="CreatePet"
          component={CreatePetScreen}
          options={{ title: 'Add new pet' }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

const MyPetsScreen = ({navigation}) => {
  const isFocused = useIsFocused();
  const [pets, setPets] = useState([]);
  const [isLoading, setLoading] = useState(true);
  const [asyncIdUser, setAsyncIdUser] = useState(null);


  const getAsyncIdUser = async () => {
    const idUser = await getData('user_id');
    setAsyncIdUser(idUser);
  };

 

  const fetchData = async () => {
    try {
      const response = await fetch(
        SITE + 'getPets.php?user_id='+asyncIdUser,
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        }
      );
  

      const data = await response.json();

      setPets(data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  useEffect(() => {
    getAsyncIdUser();
  }, []);

  useFocusEffect(
    React.useCallback(() => {
      if (asyncIdUser !== null) {
        fetchData();
      }
    }, [asyncIdUser])
  );
  

  const renderItem = ({ item }) => (
    <View style={styles.item}>
      <Text style={styles.strong}>{item.name}</Text>
        <TouchableOpacity style={styles.customButton} onPress={() =>
          navigation.navigate('PetData', { id: item.pet_id})}>
          <Text style={styles.buttonText}>More information</Text>
        </TouchableOpacity>
    </View>
  );


  return (
    <>
      {asyncIdUser === null || asyncIdUser === undefined ? (
        <View style={styles.navContainer}>
          <Button
            title="Login"
            onPress={() =>
              navigation.navigate('Login')
            }
          />
        </View>
      ) : (
        <View style={styles.navContainer}>
          <Button
            title="Logout"
            onPress={async () => {
              await removeData('user_id');
              setAsyncIdUser(null);
              setPets([]);
              Alert.alert('Logout', 'You have been logged out!');
            }}
          />

          <Button title="Add new pet" onPress={() => navigation.navigate('CreatePet')} />


        </View>
      )}
      {isLoading ? (
        <ActivityIndicator animating={true} size="large" style={{ opacity: 1 }} color="#00f" />
      ) : (
        <FlatList
          data={pets}
          keyExtractor={(item) => item.pet_id.toString()}
          renderItem={renderItem}
        />
      )}
    </>
  );
};



const LoginScreen = ({ navigation }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setLoading] = useState(true);


  const login = async () => {
    if (email === '' || password === '') {
      Alert.alert('Error', 'Fill all the fields!');
    }
    else if (password.length < 8) {
      Alert.alert('Error', 'Password too short!');
    }
    else {
      try {
        setLoading(true);

        const response = await fetch(
          SITE + 'login.php',
          {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
          }
        );

        const result = await response.json();

        if (response.ok) {
          Alert.alert('Success', result.message);

          await storeData('user_id', result.user_id);
          await storeData('email', result.email);
          navigation.navigate('MyPets', {});

        } else {
          Alert.alert('Error', result.message);
        }
      } catch (error) {
        console.error('Error updating data:', error);
        Alert.alert('Error', 'Failed to update data.');
      }
      finally {
        setLoading(false);
      }
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Login</Text>
      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        style={styles.input}
        placeholder="Password"
        secureTextEntry
        value={password}
        onChangeText={setPassword}
      />
      <Button title="Login" onPress={login} />
    </View>
  )
};

const PetDataScreen = ({ navigation, route }) => {
  const isFocused = useIsFocused();
  const [pet, setPet] = useState([]);
  const [isLoading, setLoading] = useState(true);
  const [asyncIdUser, setAsyncIdUser] = useState(null);


  const deletePet = async (id) => {
    try {
      await fetch(
        SITE + 'deletePet.php',
        {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ "pet_id": id }),
        });

      fetchData(asyncIdUser);
      Alert.alert('Pet deleted', 'You successfully deleted your pet!');
      
      navigation.goBack();
    } catch (error) {
      console.error('Error deleting item:', error);
    }
  };



  const getAsyncIdUser = async () => {
    const idUser = await getData('user_id');
    setAsyncIdUser(idUser);
  };

  const fetchData = async () => {
    try {
      const response = await fetch(
        SITE + 'getPetData.php?pet_id='+ route.params.id,
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        }
      );
  

      const data = await response.json();

      setPet(data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  useEffect(() => {
    if (isFocused) {
      getAsyncIdUser();
    }
  }, [isFocused]);

  useEffect(() => {
    if (asyncIdUser !== null) {
      fetchData();
    }
  }, [asyncIdUser]);

  return (
    <>
      {isLoading ? (

        <ActivityIndicator animating={true} size="large" style={{ opacity: 1 }} color="#00f" />
      ) : (
        <View style={styles.container}>
          <View style={styles.item}>
            <Text style={styles.big}>{pet.petname}</Text>
          </View>

          <View style={styles.groupedItems}>
            <Text style={styles.data}>Breed: {pet.breed}</Text>
            <Text style={styles.data}>Age: {pet.age}</Text>
            <Text style={styles.data}>Gender: {pet.gender}</Text>
            <Text style={styles.data}>Veterinarian: {pet.vetname}</Text>
            <Text style={styles.data}>Other: {pet.other}</Text>
          </View>
          
          <View style={[styles.outsideItem, { flexDirection: 'row', justifyContent: 'center', alignItems: 'center' }]}>
            <TouchableOpacity style={[styles.customButton, { marginRight: 10 }]}  onPress={() => navigation.navigate('EditPet', { id: pet.pet_id })}>
              <Text style={styles.buttonText}>Edit</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.deleteButton} onPress={() => deletePet(pet.pet_id)}>
              <Text style={styles.buttonText}>Delete</Text>
            </TouchableOpacity>
          </View>
        
          
        </View>
      )}
    </>
  );



};

const EditPetScreen = ({ navigation, route }) => {
  const isFocused = useIsFocused();
  const [petData, setPet] = useState([]);
  const [name, setName] = useState('');
  const [age, setAge] = useState('');
  const [other, setOther] = useState('');
  const [isLoading, setLoading] = useState(false);
  
  

  const update = async () => {
    if (name === '' || age === '') {
      Alert.alert('Error', 'Name and age fields can not be empty!');
    }
    else if (isNaN(age)) {
      Alert.alert('Error', 'Age has to be a number!');
    }
    else {
      try {
        setLoading(true);

        const response = await fetch(
          SITE + 'editPet.php',
          {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ "pet_id": route.params.id, "name": name, "age": age, "other" : other }),
          }
        );

        const result = await response.json();
        
        console.log(result);

        if (response.ok) {
          Alert.alert('Success', result.message);
          navigation.navigate('MyPets');
        } else {
          Alert.alert('Error', result.message);
        }
      } catch (error) {
        console.error('Error updating data:', error);
        Alert.alert('Error', 'Failed to update data.');
      }
      finally {
        setLoading(false);
      }
    }
  };
  const fetchData = async () => {
    try {
      const response = await fetch(
        SITE + 'getPetData.php?pet_id='+ route.params.id,
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        }
      );
  

      const data = await response.json();

      setPet(data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  
  useEffect(() => {
    if (isFocused) {
      fetchData();
    }
  }, [isFocused]);


  return (
    <>
      {isLoading ? (
        <ActivityIndicator animating={true} size="large" style={{ opacity: 1 }} color="#00f" />
      ) : (
        <View style={styles.container}>
          <Text style={styles.title}>Name:</Text>
          <TextInput
            style={styles.input}
            placeholder={petData.petname}
            onChangeText={setName}
          />
          <Text style={styles.title}>Age:</Text>
          <TextInput
            style={styles.input}
            
            onChangeText={setAge}
          />
          <Text style={styles.title}>Other:</Text>
          <TextInput
            style={styles.input}
            placeholder={petData.other}
            onChangeText={setOther}
          />
          <Button title="Edit" onPress={update} />
        </View>
      )}
    </>
  )



};

const CreatePetScreen = ({ navigation }) => {
  const isFocused = useIsFocused();
  const [breeds, setBreeds] = useState([]);
  const [vets, setVets] = useState([]);
  const [isLoading, setLoading] = useState(true);
  const [asyncIdUser, setAsyncIdUser] = useState(null);
  const [selectedBreed, setSelectedBreed] = useState('');
  const [selectedVet, setSelectedVet] = useState('');


  const [name, setName] = useState('');
  const [breed_id, setBreedId] = useState('');
  const [vet_id, setVetId] = useState('');
  const [age, setAge] = useState('');
  const [gender, setGender] = useState('');
  const [other, setOther] = useState('');

  const insert = async () => {
    if (name === '' || age === '' || breed_id === '' || vet_id === '' || gender === '') {
      Alert.alert('Error', 'Fill all the fields!');
    }
    else if (isNaN(age)) {
      Alert.alert('Error', 'Age has to be a number!');
    }
    else {
      try {
        setLoading(true);

        const response = await fetch(
          SITE + 'insertPet.php',
          {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ "user_id": asyncIdUser, "name": name, "breed_id": breed_id , "vet_id":vet_id , "age": age, "gender": gender, "other" : other }),
          }
        );

        const result = await response.json();
        
        console.log(result);

        if (response.ok) {
          Alert.alert('Success', result.message);
          navigation.navigate('MyPets');
        } else {
          Alert.alert('Error', result.message);
        }
      } catch (error) {
        console.error('Error updating data:', error);
        Alert.alert('Error', 'Failed to update data.');
      }
      finally {
        setLoading(false);
      }
    }
  };


  const getAsyncIdUser = async () => {
    const idUser = await getData('user_id');
    setAsyncIdUser(idUser);
  };

  const fetchVets = async () => {
    try {
      const response = await fetch(
        SITE + 'getVets.php?',
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        }
      );
  

      const data = await response.json();

      setVets(data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  const fetchBreeds = async () => {
    try {
      const response = await fetch(
        SITE + 'getBreeds.php?',
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        }
      );
  

      const data = await response.json();

      setBreeds(data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  useEffect(() => {
    if (isFocused) {
      getAsyncIdUser();
    }
  }, [isFocused]);

  useEffect(() => {
    if (asyncIdUser !== null) {
      fetchVets();
      fetchBreeds();
    }
  }, [asyncIdUser]);

  useEffect(() => {
    setBreedId(selectedBreed);
  }, [selectedBreed]);

  useEffect(() => {
    setVetId(selectedVet);
  }, [selectedVet]);
  

  return (
    <>
      {isLoading ? (
        <ActivityIndicator animating={true} size="large" style={{ opacity: 1 }} color="#00f" />
      ) : (
        <View style={styles.container}>
          <Text style={styles.title}>Name:</Text>
          <TextInput
            style={styles.input}         
            onChangeText={setName}
          />
          <Text style={styles.title}>Breed:</Text>
          <Picker
            selectedValue={selectedBreed}
            onValueChange={(itemValue) => setSelectedBreed(itemValue)}
          >
            <Picker.Item label="Select an option" value="" />
            {breeds.map((breed) => (
              <Picker.Item key={breed.breed_id} label={breed.breed} value={breed.breed_id} />
            ))}
          </Picker>
          
          <Text style={styles.title}>Veterinarians:</Text>
          <Picker
            selectedValue={selectedVet}
            onValueChange={(itemValue) => setSelectedVet(itemValue)}
          >
            <Picker.Item label="Select an option" value="" />
            {vets.map((vet) => (
              <Picker.Item key={vet.vet_id} label={vet.vetname} value={vet.vet_id} />
            ))}
          </Picker>

          <Text style={styles.title}>Age:</Text>
          <TextInput
            style={styles.input}          
            onChangeText={setAge}
          />
          <Text style={styles.title}>Gender:</Text>
          <TextInput
            style={styles.input}
            onChangeText={setGender}
          />
          <Text style={styles.title}>Other:</Text>
          <TextInput
            style={styles.input}
            onChangeText={setOther}
          />
          <Button title="Register" onPress={insert} />
        </View>
      )}
    </>
  )


};

const styles = StyleSheet.create({
  navContainer: {
    flexDirection: 'row',
    justifyContent: 'space-evenly',
    alignItems: 'center',
    backgroundColor: 'lightgray',
    paddingVertical: 10,

  },

  container: {
    flex: 1,
    padding: 26,
    justifyContent: 'center',

    marginTop: 16,
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginBottom: 16,
    paddingHorizontal: 8,

  },
  outsideItem:{

    padding: 20,
    marginVertical: 8,
    marginHorizontal: 20,
    alignItems: 'center',
  },
  item: {
    backgroundColor: '#e9e9e9',
    padding: 20,
    marginVertical: 8,
    marginHorizontal: 20,
    alignItems: 'center',
    borderColor: '#cecece',
    borderWidth: 5,
    borderRadius: 20
  },
  groupedItems: {
    backgroundColor: '#e9e9e9',
    padding: 20,
    marginVertical: 8,
    marginHorizontal: 20,

    borderColor: '#cecece',
    borderWidth: 5,
    borderRadius: 20
  },
  strong: {
    fontSize: 20,
    fontWeight: 'bold',
  },
  data: {
    fontSize: 16,
  },
  big: {
    fontSize: 30,
    fontWeight: 'bold'
  },
  customButton:
  {
    backgroundColor: '#00b377',
    marginTop: 10,
    padding: 8,
    borderColor: '#cecece',
    borderWidth: 5,
    borderRadius: 20
  },
  deleteButton:
  {
    backgroundColor: '#f00',
    marginTop: 10,
    padding: 8,
    borderColor: '#cecece',
    borderWidth: 5,
    borderRadius: 20,
  },
  buttonText: {
    color: '#fff'

  }

});


export default MyStack;