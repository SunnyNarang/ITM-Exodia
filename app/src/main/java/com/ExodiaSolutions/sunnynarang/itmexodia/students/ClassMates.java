package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.support.v4.view.MenuItemCompat;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.SearchView;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.amulyakhare.textdrawable.TextDrawable;
import com.ExodiaSolutions.sunnynarang.itmexodia.person;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

public class ClassMates extends AppCompatActivity {
    ListView list;
    ProgressDialog pd;
    String class_id,roll;
    String[] color = {"EF5350", "AB47BC", "7E57C2", "5C6BC0", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};

    String name="s";
    ProgressBar progressBar;
    String offline_classmates="";
    String my_class="1";
    boolean search=false;
    boolean refresh = false;
    ArrayList<person> arrayList = new ArrayList<>();
    CustomAdapter3 adapter;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu, menu);
        final MenuItem searchItem = menu.findItem(R.id.action_search);
        final SearchView searchView = (SearchView) MenuItemCompat.getActionView(searchItem);
        MenuItemCompat.setOnActionExpandListener(menu.findItem(R.id.action_search), new MenuItemCompat.OnActionExpandListener() {
            @Override
            public boolean onMenuItemActionExpand(MenuItem item) {

            search  =true;

                return true;
            }

            @Override
            public boolean onMenuItemActionCollapse(MenuItem item) {
                arrayList.clear();
                search = false;
                finish();
                startActivity(getIntent());

                //DO SOMETHING WHEN THE SEARCHVIEW IS CLOSING
                /*my_class="1";
                readItems();
                if(!offline_classmates.equalsIgnoreCase(""))
                {
                    try {

                        JSONArray root= new JSONArray(offline_classmates);

                        for(int i=0;i<root.length();i++)
                        {
                            JSONObject jsonObject=root.optJSONObject(i);

                            String name= jsonObject.optString("name");
                            String g_roll=jsonObject.optString("roll");
                            String image=jsonObject.optString("image");
                            if(!roll.equalsIgnoreCase(g_roll))
                                arrayList.add(new person(name,image,g_roll));
                        }
                        adapter.notifyDataSetChanged();
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                else if(isNetworkAvailable()){
                    ClassMatesLoader classMatesLoader = new ClassMatesLoader(ClassMates.this);
                    classMatesLoader.execute();}
                else
                {
                    Toast.makeText(ClassMates.this, "No Internet Available", Toast.LENGTH_SHORT).show();
                }*/


                return true;
            }
        });

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {

                searchView.clearFocus();

                return true;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
               if(!isNetworkAvailable())
               {
                   Toast.makeText(ClassMates.this, "Connect To Internet", Toast.LENGTH_SHORT).show();
               }else {
                   arrayList.clear();
                   adapter.notifyDataSetChanged();
                   if (newText.length() < 3) {

                   }

                /*if (profilesearch.getStatus() == AsyncTask.Status.RUNNING)
                    profilesearch.cancel(true);*/
                   if (newText.length() >= 3) {
                       my_class = "0";
                       name = newText;
                       ClassMatesLoader classMatesLoader = new ClassMatesLoader(ClassMates.this);
                       classMatesLoader.execute();

                   }


               }
                return false;
            }
        });
        return super.onCreateOptionsMenu(menu);
    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_class_mates);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Your Classmates");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);



        progressBar = (ProgressBar) findViewById(R.id.progess);
        progressBar.setVisibility(View.INVISIBLE);   // --visible
        //progressBar.setVisibility(View.VISIBLE);  //  --gone (like dismiss)
     roll = getIntent().getStringExtra("roll");
        class_id = getIntent().getStringExtra("class_id");
        readItems();
       // Toast.makeText(this, ""+offline_classmates, Toast.LENGTH_SHORT).show();
        adapter = new CustomAdapter3(this,arrayList);
        if(!offline_classmates.equalsIgnoreCase(""))
        {
            try {

                JSONArray root= new JSONArray(offline_classmates);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);

                    String name= jsonObject.optString("name");
                    String g_roll=jsonObject.optString("roll");
                    String image=jsonObject.optString("image");
                    if(!roll.equalsIgnoreCase(g_roll))
                        arrayList.add(new person(name,image,g_roll));

                }
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        else if(isNetworkAvailable()){
        ClassMatesLoader classMatesLoader = new ClassMatesLoader(this);
        classMatesLoader.execute();}
        else
        {
            Toast.makeText(this, "No Internet Available", Toast.LENGTH_SHORT).show();
        }
            if (isNetworkAvailable()) {
                ClassMatesLoader classMatesLoader = new ClassMatesLoader(ClassMates.this);
                classMatesLoader.execute();
            }

        list = (ListView) findViewById(R.id.classmates_lv);

        list.setAdapter(adapter);
        list.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {

                        person person = arrayList.get(pos);

                        Intent i = new Intent(ClassMates.this,NewProfile.class);
                        i.putExtra("roll",person.getRoll());
                        i.putExtra("image",person.getImage());
                        startActivity(i);


                    }
                }


        );


    }


    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    class CustomAdapter3 extends ArrayAdapter<person> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<person> arrayList) {
            super(context, R.layout.classmates_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.classmates_card, parent, false);

           person person = getItem(pos);

            TextView class_name = (TextView) convertView.findViewById(R.id.classmate_name);

            TextView class_roll = (TextView) convertView.findViewById(R.id.classmate_roll);

            ImageView imageView = (ImageView) convertView.findViewById(R.id.classmate_img);
            int col=pos;
            if(pos>=10){
                col=pos%10;
            }
            TextDrawable drawable = TextDrawable.builder()
                    .buildRound(String.valueOf(person.getName().charAt(0)), Color.parseColor("#"+color[col]));
            imageView.setImageDrawable(drawable);


            //class_img.setImageURI(Uri.parse(person.getImage()));
            class_name.setText(person.getName());
            class_roll.setText(person.getRoll());
/*
            Uri imageUri = Uri.parse("https://exodia-incredible100rav.c9users.io/itm/img/"+person.getImage());
            SimpleDraweeView draweeView = (SimpleDraweeView) convertView.findViewById(R.id.classmate_img);
            Drawable myIcon = getResources().getDrawable( R.drawable.user_wh );

            GenericDraweeHierarchyBuilder builder =
                    new GenericDraweeHierarchyBuilder(getResources());
            GenericDraweeHierarchy hierarchy = builder
                    .setFadeDuration(300)
                    .setPlaceholderImage(myIcon)
                    .build();
            draweeView.setHierarchy(hierarchy);
            RoundingParams roundingParams = RoundingParams.fromCornersRadius(5f);
            roundingParams.setBorder(Color.parseColor("#ffffff"), 3);
            roundingParams.setRoundAsCircle(true);
            draweeView.getHierarchy().setRoundingParams(roundingParams);
            draweeView.setImageURI(imageUri);*/
            return convertView;
        }
    }
    public class ClassMatesLoader extends AsyncTask<Void,Void,String>
    {

        Context context;
        ClassMatesLoader(Context context)
        {
            this.context=context;
        }
        @Override
        protected String doInBackground(Void... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/profile_search.php";

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("id", "UTF-8") + "=" + URLEncoder.encode(class_id, "UTF-8")+ "&"
                        + URLEncoder.encode("class", "UTF-8") + "=" + URLEncoder.encode(my_class, "UTF-8")+ "&"
                        + URLEncoder.encode("name", "UTF-8") + "=" + URLEncoder.encode(name, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "null ghjgj";

        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //if(my_class.equalsIgnoreCase("0"))
            //    progressBar.setVisibility(View.INVISIBLE);   // --visible
            progressBar.setVisibility(View.VISIBLE);
            if((my_class.equalsIgnoreCase("1")&&offline_classmates.equalsIgnoreCase(""))||refresh==true){
            pd = new ProgressDialog(ClassMates.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Files.");
            pd.setCancelable(false);
           // pd.show();
                 }
        }

        @Override
        protected void onPostExecute(String result ){
            arrayList.clear();
           // Toast.makeText(context, "Refreshed", Toast.LENGTH_SHORT).show();
            //if(my_class.equalsIgnoreCase("0"))
                    progressBar.setVisibility(View.INVISIBLE);   // --visible
                //progressBar.setVisibility(View.VISIBLE);
            if((my_class.equalsIgnoreCase("1")&&offline_classmates.equalsIgnoreCase(""))||refresh==true){
           // pd.dismiss();
                if(!my_class.equalsIgnoreCase("0"))
                writeItems(result);
            }
            String json=result;

            try {

                JSONArray root= new JSONArray(json);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);

                    String name= jsonObject.optString("name");
                    String g_roll=jsonObject.optString("roll");
                    String image=jsonObject.optString("image");
                   if(!roll.equalsIgnoreCase(g_roll))
                    arrayList.add(new person(name,image,g_roll));

                }
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }
        refresh= false;
        }
    }
    private void writeItems(String s) {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir, class_id+"classmates.txt");
        try {


            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void readItems()  {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,class_id+"classmates.txt");
        try {
            offline_classmates = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_classmates = "";
        }
    }
public void refresh_classmates(View v){
    if(search==false){
    if(isNetworkAvailable()){

        refresh = true;
        ClassMatesLoader classMatesLoader = new ClassMatesLoader(ClassMates.this);
        classMatesLoader.execute();}
    else
    {
        Toast.makeText(ClassMates.this, "No Internet Available", Toast.LENGTH_SHORT).show();
    }}
}
}
