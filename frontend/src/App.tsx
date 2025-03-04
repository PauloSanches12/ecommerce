import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import ProductList from './pages/ProductList';
import ProductDetails from './pages/ProductDetails';
import Login from './pages/Login';
import Register from './pages/Register';
import Home from './pages/Home';
import { AuthProvider } from './contexts/AuthContext';
import PrivateRoute from './routes/PrivateRoute';
import AddProduct from './pages/AddProduct';
import EditProduct from './pages/EditProduct';

function App() {
  return (
    <AuthProvider>
      <Router>
        <div className="App">
          <Navbar />
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
            <Route
              path="/products"
              element={<PrivateRoute element={<ProductList />} />}
            />
            <Route
              path="/products/:id"
              element={<PrivateRoute element={<ProductDetails />} />}
            />
            <Route
              path="/products/:id/edit"
              element={<PrivateRoute element={<EditProduct />} />}
            />
            <Route
              path="/add-product"
              element={<PrivateRoute element={<AddProduct />} />}
            />
          </Routes>
        </div>
      </Router>
    </AuthProvider>
  );
}

export default App;