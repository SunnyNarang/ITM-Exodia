package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.text.Html;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.amulyakhare.textdrawable.TextDrawable;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.RecyclerItemClickListener;

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

public class Subjects extends AppCompatActivity {

    ArrayList<Sub_class1> arrayList = new ArrayList<>();
    ProgressDialog pd;
    //CustomAdapter3 adapter;
    //ListView list;
    String roll;
    RecyclerView recyclerView;
    RecyclerCustomAdapter adapter;
    SubjectLoader subjectLoader;
    String class_id,offline_subjects="";
    static String[] color = {"EF5350", "AB47BC", "7E57C2", "5C6BC0", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};

    @Override
    protected void onPause() {
        super.onPause();
        if(subjectLoader.getStatus()==AsyncTask.Status.RUNNING)
        subjectLoader.cancel(true);
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Subjects.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_subjects);
        subjectLoader = new SubjectLoader(this);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Your Subjects");

        roll = getIntent().getStringExtra("roll");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);


        class_id = getIntent().getStringExtra("class_id");
        readItems();

        recyclerView = (RecyclerView) findViewById(R.id.subject_listview);


        if(!offline_subjects.equalsIgnoreCase("")){
            try {

                JSONArray root= new JSONArray(offline_subjects);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);

                    String id= jsonObject.optString("id");
                    String name=jsonObject.optString("name");
                    String code=jsonObject.optString("code");
                    String type = jsonObject.optString("type");

                    Sub_class1 sub_class1=new Sub_class1(id,name,code,type);
                    arrayList.add(sub_class1);
                }

            } catch (JSONException e) {
                e.printStackTrace();
            }   
        }  
        if(isNetworkAvailable()){
         //   Toast.makeText(this, ""+class_id, Toast.LENGTH_SHORT).show();
            subjectLoader.execute();

            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( subjectLoader.getStatus() == AsyncTask.Status.RUNNING )
                    {subjectLoader.cancel(true);
                        Toast.makeText(Subjects.this, "Time OUT", Toast.LENGTH_SHORT).show();
                        if(pd.isIndeterminate())
                        pd.dismiss();
                    }
                }
            }, 20000 );
        }
        else
            {
                if(offline_subjects.equalsIgnoreCase(""))
            Toast.makeText(Subjects.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
        }
        adapter=new RecyclerCustomAdapter(Subjects.this,arrayList);
        recyclerView.setAdapter(adapter);
        LinearLayoutManager layoutManager = new LinearLayoutManager(this,LinearLayoutManager.VERTICAL,false);
        // GridLayoutManager gridLayoutManager = new GridLayoutManager(this,1);
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.addOnItemTouchListener( new RecyclerItemClickListener(Subjects.this, new RecyclerItemClickListener.OnItemClickListener() {
            @Override public void onItemClick(View view, int position) {
                // TODO Handle item click

                Sub_class1 sub_class1 = arrayList.get(position);
                Intent in = new Intent(Subjects.this,Files.class);
                in.putExtra("id",sub_class1.getId());
                in.putExtra("roll",roll);
                in.putExtra("code",sub_class1.getCode());
                startActivity(in);
            }
        }));
        /*r.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {

                        Sub_class1 sub_class1 = arrayList.get(pos);
                        Intent in = new Intent(Subjects.this,Files.class);
                        in.putExtra("id",sub_class1.getId());
                        in.putExtra("code",sub_class1.getCode());
                        startActivity(in);


                    }
                }


        );*/
    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    class CustomAdapter3 extends ArrayAdapter<Sub_class1> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<Sub_class1> arrayList) {
            super(context, R.layout.subject_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.subject_card, parent, false);

            Sub_class1 sub_class1 = getItem(pos);

            TextView sub_name = (TextView) convertView.findViewById(R.id.sub_card_name);
            ImageView imageView= (ImageView) convertView.findViewById(R.id.sub_card_img);
            TextView sub_code = (TextView) convertView.findViewById(R.id.sub_card_code);
            int col=pos;
            if(pos>10){
                col=pos%10;
            }
            TextDrawable drawable = TextDrawable.builder()
                    .buildRound(String.valueOf(sub_class1.getType()), Color.parseColor("#"+color[col]));
            sub_name.setText(sub_class1.getName());
            sub_code.setText(sub_class1.getCode());
            imageView.setImageDrawable(drawable);
            return convertView;

        }
    }

    public static class RecyclerCustomAdapter extends
            RecyclerView.Adapter<Subjects.RecyclerCustomAdapter.ViewHolder> {

        Context mContext;
        ArrayList<Sub_class1> mArrayList;

        //constructor
        public RecyclerCustomAdapter(Context context,ArrayList<Sub_class1> marrayList){
            mContext = context;
            mArrayList = marrayList;
        }

        //easy access to context items objects in recyclerView
        private Context getContext() {
            return mContext;
        }

        @Override
        public Subjects.RecyclerCustomAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            Context context = parent.getContext();
            LayoutInflater inflater = LayoutInflater.from(context);

            // Inflate the custom layout
            View contactView = inflater.inflate(R.layout.subject_card ,parent, false);

            // Return a new holder instance
            Subjects.RecyclerCustomAdapter.ViewHolder viewHolder = new Subjects.RecyclerCustomAdapter.ViewHolder(contactView);
            return viewHolder;

        }

        @Override
        public void onBindViewHolder(Subjects.RecyclerCustomAdapter.ViewHolder viewHolder, int position) {

            // Get the data model based on position
            Sub_class1 sub_class1 = mArrayList.get(position);
            //Toast.makeText(mContext, ""+sub_class1.getName(), Toast.LENGTH_SHORT).show();
            int col=position;
            if(position>=10){
                col=position%10;
            }
            TextDrawable drawable = TextDrawable.builder()
                    .buildRound(String.valueOf(sub_class1.getType()), Color.parseColor("#"+color[col]));
            TextView sub_name = viewHolder.sub_name;
            TextView sub_code = viewHolder.sub_code;
            ImageView imageView = viewHolder.imageView;

            sub_name.setText(sub_class1.getName());
            sub_code.setText(sub_class1.getCode());
            imageView.setImageDrawable(drawable);

            // Set item views based on your views and data model
            
        }

        @Override
        public int getItemCount() {
            return mArrayList.size();
        }

        // Provide a direct reference to each of the views within a data item
        // Used to cache the views within the item layout for fast access
        public static class ViewHolder extends RecyclerView.ViewHolder {
            // Your holder should contain a member variable
            // for any view that will be set as you render a row
            public TextView sub_name,sub_code;
            public ImageView imageView;

            // We also create a constructor that accepts the entire item row
            // and does the view lookups to find each subview
            public ViewHolder(View itemView) {
                // Stores the itemView in a public final member variable that can be used
                // to access the context from any ViewHolder instance.
                super(itemView);

                 sub_name = (TextView) itemView.findViewById(R.id.sub_card_name);
                imageView= (ImageView) itemView.findViewById(R.id.sub_card_img);
                sub_code = (TextView) itemView.findViewById(R.id.sub_card_code);

            }
        }
    }


    public class SubjectLoader extends AsyncTask<Void,Void,String> {

        Context context;
        SubjectLoader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/getsubjects.php";

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("class_id", "UTF-8") + "=" + URLEncoder.encode(class_id, "UTF-8");

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


            return null;

        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            if(offline_subjects.equalsIgnoreCase("")){
            pd = new ProgressDialog(Subjects.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Subjects.");
            pd.setCancelable(false);
            pd.show();}
        }

        @Override
        protected void onPostExecute(String result ){

            String json=result;

          // Toast.makeText(Subjects.this,""+result,Toast.LENGTH_LONG).show();

if(offline_subjects.equalsIgnoreCase(""))
            pd.dismiss();
            if(json!=null){
                try {
                    writeItems(result);
                    arrayList.clear();
                JSONArray root= new JSONArray(json);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);

                    String id= jsonObject.optString("id");
                    String name=jsonObject.optString("name");
                    String code=jsonObject.optString("code");
                    String type = jsonObject.optString("type");
                    Sub_class1 sub_class1=new Sub_class1(id,name,code,type);
                    arrayList.add(sub_class1);

                }

              } catch (JSONException e) {
                e.printStackTrace();
                }

                adapter.notifyDataSetChanged();
            }
        }

    }
    private void writeItems(String s) {
        
            File filesDir = getFilesDir();
            File todoFile = new File(filesDir, class_id+"subjects.txt");
            try {


                FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
            } catch (IOException e) {
                e.printStackTrace();
            }
    }

    private void readItems()  {
        
            File filesDir = getFilesDir();
            File todoFile = new File(filesDir,class_id+"subjects.txt");
            try {
                offline_subjects = new String(FileUtils.readFileToString(todoFile));
            } catch (IOException e) {
                offline_subjects = "";
            }
    }
}
